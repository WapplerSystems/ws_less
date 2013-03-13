<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['wsless'] = 'EXT:ws_less/Classes/Hooks/RenderPreProcessorHook.php:&tx_Wsless_Hooks_RenderPreProcessorHook->renderPreProcessorProc';

#$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rtehtmlarea/class.tx_rtehtmlarea_base.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClass/class.ux_tx_rtehtmlarea_base.php';



?>