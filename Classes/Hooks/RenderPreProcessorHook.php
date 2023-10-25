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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileNameException;
use TYPO3\CMS\Core\Resource\Exception\InvalidPathException;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Resource\FilePathSanitizer;

/**
 * Hook to preprocess less files
 *
 * @author Sven Wappler <typo3YYYY@wapplersystems.de>
 * @author Jozef Spisiak <jozef@pixelant.se>
 * @author Oliver Schlöbe <oli@joppnet.de>
 */
class RenderPreProcessorHook
{
    protected \Less_Parser $parser;

    private array $variables = [];

    private ?ContentObjectRenderer $contentObjectRenderer = null;

    /** Visited files of hash calculator */
    private static array $visitedFiles = [];

    /**
     * Main hook function
     *
     * @param array $params Array of CSS/javascript and other files
     * @throws NoSuchCacheException
     * @throws FileDoesNotExistException
     * @throws InvalidFileException
     * @throws InvalidFileNameException
     * @throws InvalidPathException
     */
    public function renderPreProcessorProc(array &$params, PageRenderer $pagerenderer): void
    {
        if (!\is_array($params['cssFiles']) || !isset($GLOBALS['TSFE'])) {
            return;
        }

        $defaultOutputDir = 'typo3temp/assets/css/';

        $sitePath = Environment::getPublicPath() . '/';

        $setup = $GLOBALS['TSFE']->tmpl->setup;
        if (\is_array($setup['plugin.']['tx_wsless.']['variables.'] ?? false)) {
            $variables = $setup['plugin.']['tx_wsless.']['variables.'];

            $parsedTypoScriptVariables = [];
            foreach ($variables as $variable => $key) {
                if (array_key_exists($variable . '.', $variables)) {
                    if ($this->contentObjectRenderer === null) {
                        $this->contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                    }
                    $content = $this->contentObjectRenderer->cObjGetSingle($variables[$variable], $variables[$variable . '.']);
                    $parsedTypoScriptVariables[$variable] = $content;
                } elseif (!str_ends_with($variable, '.')) {
                    $parsedTypoScriptVariables[$variable] = $key;
                }
            }
            $this->variables = $parsedTypoScriptVariables;
        }

        $variablesHash = count($this->variables) > 0 ? hash('md5', implode(',', $this->variables)) : null;

        $filePathSanitizer = GeneralUtility::makeInstance(FilePathSanitizer::class);

        // we need to rebuild the CSS array to keep order of CSS
        // files
        $cssFiles = [];

        foreach ($params['cssFiles'] as $file => $conf) {
            $pathInfo = pathinfo($conf['file']);

            if (($pathInfo['extension'] ?? '') !== 'less') {
                $cssFiles[$file] = $conf;
                continue;
            }

            $filename = $pathInfo['filename'];

            $outputDir = $defaultOutputDir;
            $outputFile = null;
            $doNotHash = false;

            // search settings for less file
            foreach ($GLOBALS['TSFE']->pSetup['includeCSS.'] ?? [] as $key => $subconf) {
                if (\is_string($subconf) && $filePathSanitizer->sanitize($subconf) === $file) {
                    $subInnerConf = $GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.'];
                    $outputDir = isset($subInnerConf['outputdir']) ? trim($subInnerConf['outputdir']) : $outputDir;
                    if (isset($subInnerConf['doNotHash']) && $subInnerConf['doNotHash'] == 1
                    ) {
                        $doNotHash = true;
                    }
                    $outputFile = isset($subInnerConf['outputfile']) ? trim($subInnerConf) : null;
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
            $cssRelativeFilename = $outputDir . $filename . (($outputDir === $defaultOutputDir && $outputFile === '') ? '_' . hash(
                        'sha1',
                        $file
                    ) : (\count($this->variables) > 0 && $outputFile === '' ? '_' . $variablesHash : '')) . '.css';
            if ($doNotHash) {
                $cssRelativeFilename = $outputDir . $filename . '.css';
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
                if ($contentHashCache === '' || $contentHashCache !== $contentHash || $GLOBALS['TSFE']->no_cache) {
                    $this->compileScss($lessFilename, $cssFilename, $strVars);
                    $cache->set($cacheKey, $contentHash, []);
                }
            } catch (\Exception $ex) {
                // log the exception to the TYPO3 log as error
                echo $ex->getMessage();

                /** @var Logger $logger */
                $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
                $logger->error($ex->getMessage());
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
     */
    protected function compileScss(string $lessFilename, string $cssFilename, string $vars): string
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
     */
    protected function calculateContentHash(string $lessFilename, string $vars = ''): string
    {
        if (in_array($lessFilename, self::$visitedFiles)) {
            return '';
        }
        self::$visitedFiles[] = $lessFilename;

        $content = file_get_contents($lessFilename);
        if (is_bool($content)) {
            /** @var Logger $logger */
            $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
            $logger->error('Could not read less file: ' . $lessFilename);
            return '';
        }
        $pathInfo = pathinfo($lessFilename);

        $hash = hash('sha1', $content);
        if ($vars !== '') {
            $hash = hash('sha1', $hash . $vars);
        } // hash variables too

        preg_match_all('/@import "([^"]*)"/', $content, $imports);

        foreach ($imports[1] as $import) {
            $hashImport = '';
            $direname = $pathInfo['dirname'] ?? '';

            if (file_exists($direname . '/' . $import . '.less')) {
                $hashImport = $this->calculateContentHash($direname . '/' . $import . '.less');
            } elseif (file_exists($direname . '/' . $import)) {
                $hashImport = $this->calculateContentHash($direname . '/' . $import);
            }
            if ($hashImport !== '') {
                $hash = hash('sha1', $hash . $hashImport);
            }
        }

        return $hash;
    }
}
