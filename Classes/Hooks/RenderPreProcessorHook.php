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
 * 
 *
 */
class tx_Wsless_Hooks_RenderPreProcessorHook {


	protected $parser;
	
	/**
	 * 
	 */
	public function renderPreProcessorProc(&$params, $pagerenderer) {
		
		
		$this->parser = new lessc();
		
		if (!is_array($params['cssFiles'])) return;
		
		foreach ($params['cssFiles'] as $file => $conf) {
			$pathinfo = pathinfo($conf['file']);
			
			if ($pathinfo['extension'] == 'less') {
				
				$options = array();
				$outputdir = "typo3temp";
				$basepath = "";
				
				// search settings for less file
				foreach ($GLOBALS['TSFE']->pSetup['includeCSS.'] as $key => $subconf) {
					
					if ($GLOBALS['TSFE']->pSetup['includeCSS.'][$key] == $file) {
						if (isset($GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['basepath'])) $basepath = $GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['basepath'];
						if (isset($GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['outputdir'])) $outputdir = rtrim($GLOBALS['TSFE']->pSetup['includeCSS.'][$key . '.']['outputdir'],"/");
					}
				}
				
				
				$options['load_paths'] = array(PATH_site.$basepath);
				$lessFilename = t3lib_div::getFileAbsFileName($conf['file']);
				
				$cssfilename = PATH_site.$outputdir."/".$pathinfo['filename'].".css";
				
				t3lib_div::mkdir_deep(PATH_site.$outputdir."/");
				
				try {
					$this->compileScss($lessFilename, $cssfilename);
					
					$params['cssFiles'][$file]['file'] = $outputdir."/".$pathinfo['filename'].".css";
					
					$params['cssFiles'][$outputdir."/".$pathinfo['filename'].".css"] = $params['cssFiles'][$file];
					
					unset($params['cssFiles'][$file]);
					
					
				} catch (Exception $ex) {
					
				}
				
			}
			
		}

		
	}
	
	
	
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