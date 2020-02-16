<?php
defined('TYPO3_MODE') or die();

$boot = function () {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['wsless'] = \WapplerSystems\WsLess\Hooks\RenderPreProcessorHook::class . '->renderPreProcessorProc';

	// Caching the pages - default expire 3600 seconds
	if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['ws_less'])) {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['ws_less'] = array(
			'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
			'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\FileBackend',
			'options' => array(
				'defaultLifetime' => 3600*24*7
			),
		);
	}
};

$boot();
unset($boot);