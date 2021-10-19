<?php
namespace WapplerSystems\WsLess\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 WapplerSystems <typo3YYYY@wapplersystems.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Hook to preprocess less files
 *
 * @author Sven Wappler <typo3YYYY@wapplersystems.de>
 * @author Jozef Spisiak <jozef@pixelant.se>
 * @author Oliver Schlöbe <oli@joppnet.de>
 *
 */
class RenderPreProcessorHook
{

    protected $parser;

    private $variables = [];

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    private $contentObjectRenderer;

    /**
     * Visited files of hash calculator
     * @var array
     */
    private static $visitedFiles = [];

    /**
     * Main hook function
     *
     * @param array $params Array of CSS/javascript and other files
     * @param object $pagerenderer Pagerenderer object
     * @return null
     *
     */
    public function renderPreProcessorProc(&$params, \TYPO3\CMS\Core\Page\PageRenderer $pagerenderer): void
    {

        if (!\is_array($params['cssFiles'])) {
            return;
        }

        $defaultOutputDir = 'typo3temp/assets/css/';

        $sitePath = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/';

        $setup = $GLOBALS['TSFE']->tmpl->setup;
        if (\is_array($setup['plugin.']['tx_wsless.']['variables.'])) {

            $variables = $setup['plugin.']['tx_wsless.']['variables.'];

            $parsedTypoScriptVariables = [];
            foreach ($variables as $variable => $key) {
                if (array_key_exists($variable . '.', $variables)) {
                    if ($this->contentObjectRenderer === null) {
                        $this->contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                    }
                    $content = $this->contentObjectRenderer->cObjGetSingle($variables[$variable], $variables[$variable . '.']);
                    $parsedTypoScriptVariables[$variable] = $content;

                } elseif (substr($variable, -1) !== '.') {
                    $parsedTypoScriptVariables[$variable] = $key;
                }
            }
            $this->variables = $parsedTypoScriptVariables;
        }


        $variablesHash = count($this->variables) > 0 ? hash('md5', implode(",", $this->variables)) : null;

        $filePathSanitizer = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Resource\FilePathSanitizer::class);

        // we need to rebuild the CSS array to keep order of CSS
        // files
        $cssFiles = [];
        foreach ($params['cssFiles'] as $file => $conf) {
            $pathInfo = pathinfo($conf['file']);

            if ($pathInfo['extension'] !== 'less') {
                $cssFiles[$file] = $conf;
                continue;
            }

            $filename = $pathInfo['filename'];


            $outputDir = $defaultOutputDir;
            $outputFile = '';
            $doNotHash = false;
            $doNotInclude = false;

            // search settings for less file
            foreach ($GLOBALS['TSFE']->pSetup['includeCSS.'] as $key => $subconf) {
                $localConfig = $GLOBALS['TSFE']->pSetup['includeCSS.'][$key];
                $localSubConfigArray = $GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.'];
                if (\is_string($localConfig) && $filePathSanitizer->sanitize($localConfig) === $file) {
                    $outputDir = isset($localSubConfigArray['outputdir']) ? trim($localSubConfigArray['outputdir']) : $outputDir;
                    if (isset($localSubConfigArray['doNotHash']) && $localSubConfigArray['doNotHash'] == 1) {
                        $doNotHash = true;
                    }
                    if (isset($localSubConfigArray['doNotInclude']) && $localSubConfigArray['doNotInclude'] == 1) {
                        $doNotInclude = true;
                    }
                    $outputFile = isset($localSubConfigArray['outputfile']) ? trim($localSubConfigArray['outputfile']) : null;
                }
            }
            if ($outputFile !== null) {
                $outputDir = \dirname($outputFile);
                $filename = basename($outputFile);
            }

            $outputDir = (substr($outputDir, -1) === '/') ? $outputDir : $outputDir . '/';


            if (!strcmp(substr($outputDir, 0, 4), 'EXT:')) {
                [$extKey, $script] = explode('/', substr($outputDir, 4), 2);
                if ($extKey && ExtensionManagementUtility::isLoaded($extKey)) {
                    $extPath = ExtensionManagementUtility::extPath($extKey);
                    $outputDir = substr($extPath, strlen($sitePath)) . $script;
                }
            }


            $lessFilename = GeneralUtility::getFileAbsFileName($conf['file']);

            // create filename - hash is important due to the possible
            // conflicts with same filename in different folder
            GeneralUtility::mkdir_deep($sitePath . $outputDir);
            $cssRelativeFilename = $outputDir . $filename . (($outputDir === $defaultOutputDir && $outputFile === '') ? '_' . hash('sha1',
                        $file) : (\count($this->variables) > 0 && $outputFile === '' ? '_' . $variablesHash : '')) . '.css';
            if ($doNotHash) {
                $cssRelativeFilename = $outputDir . $filename.'.css';
            }
            $cssFilename = $sitePath . $cssRelativeFilename;


            $strVars = '';
            foreach ($this->variables as $key => $value) {
                $strVars .= '@' . $key . ': ' . $value . ';';
            }


            $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('ws_less');

            $cacheKey = hash('sha1', $cssRelativeFilename);
            $contentHash = $this->calculateContentHash($lessFilename, $strVars);
            $contentHashCache = '';
            if ($cache->has($cacheKey)) {
                $contentHashCache = $cache->get($cacheKey);
            }

            try {
                if ($contentHashCache === '' || $contentHashCache !== $contentHash || $GLOBALS['TSFE']->no_cache || $GLOBALS['TSFE']->headerNoCache()) {
                    $this->compileScss($lessFilename, $cssFilename, $strVars);
                    $cache->set($cacheKey, $contentHash, []);
                }
            } catch (\Exception $ex) {
                // log the exception to the TYPO3 log as error
                echo $ex->getMessage();

                /** @var $logger Logger */
                $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
                $logger->error($ex->getMessage());
            }
            if($doNotInclude){
                continue;
            }
            $cssFiles[$cssRelativeFilename] = $params['cssFiles'][$file];
            $cssFiles[$cssRelativeFilename]['file'] = $cssRelativeFilename;
        }
        $params['cssFiles'] = $cssFiles;
    }

    /**
     * Compiling Scss with less
     *
     * @param string $lessFilename Existing less file absolute path
     * @param string $cssFilename File to be written with compiled CSS
     * @return string
     *
     */
    protected function compileScss($lessFilename, $cssFilename, $vars)
    {

        if (!class_exists(\Less_Autoloader::class)) {
            $extPath = ExtensionManagementUtility::extPath('ws_less');
            require_once($extPath . 'Resources/Private/PHP/less.php/lib/Less/Autoloader.php');
        }
        \Less_Autoloader::register();

        $parser = new \Less_Parser();
        if (file_exists($lessFilename)) {

            $parser->parseFile($lessFilename);
            $parser->parse($vars);
            $css = $parser->getCss();

            GeneralUtility::writeFile($cssFilename, $css);

            return $cssFilename;
        }

        return '';
    }


    /**
     * Calculating content hash to detect changes
     *
     * @param string $lessFilename Existing scss file absolute path
     * @param string $vars
     * @return string
     */
    protected function calculateContentHash($lessFilename, $vars = "")
    {
        if (in_array($lessFilename, self::$visitedFiles)) {
            return '';
        }
        self::$visitedFiles[] = $lessFilename;

        $content = file_get_contents($lessFilename);
        $pathInfo = pathinfo($lessFilename);

        $hash = hash('sha1', $content);
        if ($vars !== '') {
            $hash = hash('sha1', $hash . $vars);
        } // hash variables too

        preg_match_all('/@import "([^"]*)"/', $content, $imports);

        foreach ($imports[1] as $import) {
            $hashImport = '';


            if (file_exists($pathInfo['dirname'] . '/' . $import . '.less')) {
                $hashImport = $this->calculateContentHash($pathInfo['dirname'] . '/' . $import . '.less');
            } else if (file_exists($pathInfo['dirname'] . '/' . $import)) {
                $hashImport = $this->calculateContentHash($pathInfo['dirname'] . '/' . $import);
            }
            if ($hashImport !== '') {
                $hash = hash('sha1', $hash . $hashImport);
            }
        }

        return $hash;
    }

}
