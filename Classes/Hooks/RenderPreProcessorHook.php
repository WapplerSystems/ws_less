<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 WapplerSystems <typo3YYYY@wapplersystems.de>
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

/**
 * Hook to preprocess less files
 *
 */
class tx_Wsless_Hooks_RenderPreProcessorHook {

	protected $parser;
	
	/**
	 * Main hook function
	 * 
	 * @param array $params Array of CSS/javascript and other files
	 * @param object $pagerendere Pagerenderer object
	 * @return null
	 *
	 */
	public function renderPreProcessorProc(&$params, $pagerenderer) {

		$this->parser = new lessc();

		if (!is_array($params['cssFiles'])) return;

		// we need to rebuild the CSS array to keep order of CSS files
		$cssFiles = array();
		foreach ($params['cssFiles'] as $file => $conf) {
			$pathinfo = pathinfo($conf['file']);
			
			if ($pathinfo['extension'] == 'less') {

				$outputdir = "typo3temp";

				// search settings for less file
				foreach ($GLOBALS['TSFE']->pSetup['includeCSS.'] as $key => $subconf) {
					if ($GLOBALS['TSFE']->pSetup['includeCSS.'][$key] == $file) {
						if (isset($GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['outputdir'])) $outputdir = rtrim($GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['outputdir'],"/");
					}
				}

				$lessFilename = t3lib_div::getFileAbsFileName($conf['file']);

				$cssRelativeFilename = $outputdir."/".$pathinfo['filename'].".css";
				$cssFilename = PATH_site.$cssRelativeFilename;

				t3lib_div::mkdir_deep(PATH_site.$outputdir."/");

				try {
					$this->compileScss($lessFilename, $cssFilename);
				} catch (Exception $ex) {
					// log the exception to the TYPO3 log as error
				}

				$cssFiles[$cssRelativeFilename] = $params['cssFiles'][$file];
				$cssFiles[$cssRelativeFilename]['file'] = $cssRelativeFilename;
			}
			else
			{
				$cssFiles[$file] = $conf;
			}
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
	protected function compileScss($lessFilename, $cssFilename) {

		if (file_exists($lessFilename)) {
			if (t3lib_div::isAllowedAbsPath($lessFilename)) {
				$cssContent = $this->parser->compileFile($lessFilename);
				t3lib_div::writeFile($cssFilename, $cssContent);
			} else {
				throw new Exception('Output filename ' . $cssFilename . ' is not allowed', 1299059883);
			}
		}
		return $cssFilename;
	}
}
?>