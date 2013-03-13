<?php

class ux_tx_rtehtmlarea_base extends tx_rtehtmlarea_base {

	/**
	 * @return string
	 */
	public function getContentCssFileName() {

		if (!isset($this->thisConfig['contentCSS']) || !$this->thisConfig['contentCSS']) {
			return parent::getContentCssFileName();
		}
		
		$FeConfigManager = t3lib_div::makeInstance('Tx_Extbase_Configuration_FrontendConfigurationManager');
		$ts = $FeConfigManager->getTypoScriptSetup();
		
		
		

		$settings = Tx_AdxLess_Utility_LessCompiler::getTypoScriptByPageUid($this->currentPage);
		$fileSuffixes = Tx_Extbase_Utility_Arrays::trimExplode(',', $settings['fileSuffixes']);
		$cssFiles = array();

		$fileName = $this->thisConfig['contentCSS'];

		$found = FALSE;
		foreach ($fileSuffixes as $fileSuffix) {
			if (strpos($fileName, $fileSuffix) !== FALSE) {
				$found = TRUE;
				break;
			}
		}

		if ($found) {
			// get source
			$sourceFilePathAndName = t3lib_div::getFileAbsFileName($fileName);
			$source = t3lib_div::getUrl($sourceFilePathAndName);
			$content = Tx_AdxLess_Utility_LessCompiler::compile($source, $settings['lessphp.']);

			// write file
			$this->thisConfig['contentCSS'] = TSpagegen::inline2TempFile($content, 'css');
		}

		return parent::getContentCssFileName();
	}

}

?>