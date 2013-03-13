<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$extensionClassesPath = t3lib_extMgm::extPath('ws_less');

return array(
	'lessc' => $extensionClassesPath . 'Resources/Private/PHP/lessphp/lessc.inc.php',
);

?>