<?php
namespace WapplerSystems\WsLess\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 WapplerSystems <typo3YYYY@wapplersystems.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3
 * project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as
 * published by
 *  the Free Software Foundation; either version 2 of the
 * License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be
 * useful,
 *  but WITHOUT ANY WARRANTY; without even the implied
 * warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See
 * the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the
 * script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hook to preprocess less files
 *
 * @author Sven Wappler <typo3YYYY@wapplersystems.de>
 * @author Jozef Spisiak <jozef@pixelant.se>
 *
 */
class RenderPreProcessorHook {

	protected $parser;

	protected $defaultoutputdir = "typo3temp/ws_less/";

	private $variables = array();

	/**
	 * Main hook function
	 *
	 * @param array $params Array of CSS/javascript and other
	 * files
	 * @param object $pagerendere Pagerenderer object
	 * @return null
	 *
	 */
	public function renderPreProcessorProc(&$params,\TYPO3\CMS\Core\Page\PageRenderer $pagerenderer) {

		if (!is_array($params['cssFiles']))
			return;

		$setup = $GLOBALS['TSFE']->tmpl->setup;
		if (is_array($setup['plugin.']['tx_wsless.']['variables.'])) {
			$this->variables = $setup['plugin.']['tx_wsless.']['variables.'];
		}

		// we need to rebuild the CSS array to keep order of CSS
		// files
		$cssFiles = array();
		foreach ($params['cssFiles'] as $file => $conf) {
			$pathinfo = pathinfo($conf['file']);

			if ($pathinfo['extension'] !== 'less') {
				$cssFiles[$file] = $conf;
				continue;
			}


			$outputdir = $this->defaultoutputdir;

			// search settings for less file
			foreach ($GLOBALS['TSFE']->pSetup['includeCSS.'] as $key => $subconf) {

				if (is_string($GLOBALS['TSFE']->pSetup['includeCSS.'][$key]) && $GLOBALS['TSFE']->tmpl->getFileName($GLOBALS['TSFE']->pSetup['includeCSS.'][$key]) == $file) {
					if (isset($GLOBALS['TSFE']->pSetup['includeCSS.'][$key.'.']['outputdir']))
						$outputdir = trim($GLOBALS['TSFE']->pSetup['includeCSS.'][$key.'.']['outputdir']);
				}
			}

			$outputdir = (substr($outputdir,-1) == '/') ? $outputdir : $outputdir."/";

			if (!strcmp(substr($outputdir,0,4),'EXT:')) {
				list($extKey,$script) = explode('/',substr($outputdir,4),2);
				if ($extKey && \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extKey)) {
					$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey);
					$outputdir = substr($extPath,strlen(PATH_site)).$script;
				}
			}


			$lessFilename = GeneralUtility::getFileAbsFileName($conf['file']);

			// create filename - hash is importand due to the possible
			// conflicts with same filename in different folder
            GeneralUtility::mkdir_deep(PATH_site.$outputdir);
			$cssRelativeFilename = $outputdir.$pathinfo['filename'].(($outputdir == $this->defaultoutputdir) ? "_".hash('sha1',$file) : "").".css";
			$cssFilename = PATH_site.$cssRelativeFilename;


            $strVars = "";
            foreach ($this->variables as $key => $value) {
                $strVars .= "@".$key.": ".$value.";";
            }


			$cache = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('ws_less');

			$cacheKey = hash('sha1',$cssRelativeFilename);
			$contentHash = $this->calculateContentHash($lessFilename,$strVars);
			$contentHashCache = '';
			if ($cache->has($cacheKey)) {
				$contentHashCache = $cache->get($cacheKey);
			}

			$requiresCompilation = $contentHashCache == '' || $contentHashCache != $contentHash;
			try {
				if ($requiresCompilation) {
					$this->compileScss($lessFilename,$cssFilename,$strVars);
				}
			} catch (Exception $ex) {
				// log the exception to the TYPO3 log as error
				echo $ex->getMessage();

                GeneralUtility::sysLog($ex->getMessage(),GeneralUtility::SYSLOG_SEVERITY_ERROR);
			}

			if ($requiresCompilation) {
				$cache->set($cacheKey,$contentHash,array());
			}

			$cssFiles[$cssRelativeFilename] = $params['cssFiles'][$file];
			$cssFiles[$cssRelativeFilename]['file'] = $cssRelativeFilename;
		}
		$params['cssFiles'] = $cssFiles;
	}

	/**
	 * Compiling Scss with less
	 *
	 * @param string $lessFilename Existing less file absolute
	 * path
	 * @param string $cssFilename File to be written with
	 * compiled CSS
	 * @return string
	 *
	 */
	protected function compileScss($lessFilename,$cssFilename,$vars) {

		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ws_less');
		require_once($extPath.'Resources/Private/less.php/lib/Less/Autoloader.php');
		\Less_Autoloader::register();

		$parser = new \Less_Parser();
		if (file_exists($lessFilename)) {

			$parser->parseFile($lessFilename);
			$parser->parse($vars);
			$css = $parser->getCss();

            GeneralUtility::writeFile($cssFilename,$css);

			return $cssFilename;
		}

		return '';
	}

	/**
	 * Calculating content hash to detect changes
	 *
	 * @param string $lessFilename Existing less file absolute
	 * path
	 * @return string
	 *
	 */
	protected function calculateContentHash($lessFilename,$vars) {
		$content = file_get_contents($lessFilename);
		$hash = hash('sha1',$content);
        $hash = hash('sha1',$hash.$vars); // hash variables too

		$matched = preg_match_all('/@import "([^"])*"/',$content,$imports);
		if (!empty($imports[0]))
			$pathinfo = pathinfo($lessFilename);

		foreach ($imports[0] as $import) {
			$importFilename = str_replace("@import",'',$import);
			$importFilename = trim(str_replace("\"",'',$importFilename));
			$hash = hash('sha1',$hash.sha1_file($pathinfo['dirname'].'/'.$importFilename));
		}

		return $hash;
	}


}
?>
