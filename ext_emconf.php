<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ws_less".
 *
 * Auto generated 26-02-2013 16:43
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Less compiler for TYPO3',
	'description' => 'Compiles less files to CSS files.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '1.1.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/ws_less',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Sven Wappler',
	'author_email' => 'typo3YYYY@wapplersystems.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.6.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:86:{s:16:"ext_autoload.php";s:4:"f447";s:12:"ext_icon.gif";s:4:"560c";s:17:"ext_localconf.php";s:4:"abaf";s:14:"ext_tables.php";s:4:"2511";s:40:"Classes/Hooks/RenderPreProcessorHook.php";s:4:"f36f";s:47:"Classes/XClass/class.ux_tx_rtehtmlarea_base.php";s:4:"5ac5";s:38:"Configuration/TypoScript/constants.txt";s:4:"ba2e";s:34:"Configuration/TypoScript/setup.txt";s:4:"17f8";s:40:"Resources/Private/Language/locallang.xml";s:4:"3201";s:43:"Resources/Private/PHP/lessphp/composer.json";s:4:"c6dd";s:43:"Resources/Private/PHP/lessphp/lessc.inc.php";s:4:"2878";s:51:"Resources/Private/PHP/lessphp/lessc.inc.php-0.3.4-2";s:4:"db5a";s:37:"Resources/Private/PHP/lessphp/LICENSE";s:4:"2887";s:38:"Resources/Private/PHP/lessphp/Makefile";s:4:"bf73";s:36:"Resources/Private/PHP/lessphp/plessc";s:4:"7577";s:39:"Resources/Private/PHP/lessphp/README.md";s:4:"0b7e";s:42:"Resources/Private/PHP/lessphp/docs/docs.md";s:4:"938e";s:47:"Resources/Private/PHP/lessphp/tests/ApiTest.php";s:4:"52df";s:48:"Resources/Private/PHP/lessphp/tests/bootstrap.sh";s:4:"4c03";s:49:"Resources/Private/PHP/lessphp/tests/InputTest.php";s:4:"141e";s:45:"Resources/Private/PHP/lessphp/tests/README.md";s:4:"4571";s:44:"Resources/Private/PHP/lessphp/tests/sort.php";s:4:"022e";s:44:"Resources/Private/PHP/lessphp/tests/test.php";s:4:"5ecb";s:65:"Resources/Private/PHP/lessphp/tests/inputs/accessors.less.disable";s:4:"8282";s:53:"Resources/Private/PHP/lessphp/tests/inputs/arity.less";s:4:"ad20";s:58:"Resources/Private/PHP/lessphp/tests/inputs/attributes.less";s:4:"1cf5";s:56:"Resources/Private/PHP/lessphp/tests/inputs/builtins.less";s:4:"4795";s:54:"Resources/Private/PHP/lessphp/tests/inputs/colors.less";s:4:"ea89";s:64:"Resources/Private/PHP/lessphp/tests/inputs/compile_on_mixin.less";s:4:"2f93";s:58:"Resources/Private/PHP/lessphp/tests/inputs/directives.less";s:4:"6352";s:54:"Resources/Private/PHP/lessphp/tests/inputs/escape.less";s:4:"1b77";s:59:"Resources/Private/PHP/lessphp/tests/inputs/font_family.less";s:4:"9763";s:54:"Resources/Private/PHP/lessphp/tests/inputs/guards.less";s:4:"e86a";s:53:"Resources/Private/PHP/lessphp/tests/inputs/hacks.less";s:4:"4227";s:50:"Resources/Private/PHP/lessphp/tests/inputs/hi.less";s:4:"2579";s:50:"Resources/Private/PHP/lessphp/tests/inputs/ie.less";s:4:"4785";s:54:"Resources/Private/PHP/lessphp/tests/inputs/import.less";s:4:"ca14";s:57:"Resources/Private/PHP/lessphp/tests/inputs/keyframes.less";s:4:"843c";s:52:"Resources/Private/PHP/lessphp/tests/inputs/math.less";s:4:"de57";s:53:"Resources/Private/PHP/lessphp/tests/inputs/media.less";s:4:"365e";s:52:"Resources/Private/PHP/lessphp/tests/inputs/misc.less";s:4:"7cb4";s:63:"Resources/Private/PHP/lessphp/tests/inputs/mixin_functions.less";s:4:"f9dc";s:69:"Resources/Private/PHP/lessphp/tests/inputs/mixin_merging.less.disable";s:4:"2a0b";s:54:"Resources/Private/PHP/lessphp/tests/inputs/mixins.less";s:4:"ed57";s:54:"Resources/Private/PHP/lessphp/tests/inputs/nested.less";s:4:"8472";s:64:"Resources/Private/PHP/lessphp/tests/inputs/pattern_matching.less";s:4:"1158";s:54:"Resources/Private/PHP/lessphp/tests/inputs/scopes.less";s:4:"7b89";s:68:"Resources/Private/PHP/lessphp/tests/inputs/selector_expressions.less";s:4:"e012";s:58:"Resources/Private/PHP/lessphp/tests/inputs/site_demos.less";s:4:"4699";s:57:"Resources/Private/PHP/lessphp/tests/inputs/variables.less";s:4:"3fd7";s:62:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/a.less";s:4:"8c6f";s:62:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/b.less";s:4:"eb43";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file1.less";s:4:"e904";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file2.less";s:4:"cccf";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file3.less";s:4:"936e";s:72:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/inner/file1.less";s:4:"55d8";s:72:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/inner/file2.less";s:4:"88fc";s:57:"Resources/Private/PHP/lessphp/tests/outputs/accessors.css";s:4:"661e";s:53:"Resources/Private/PHP/lessphp/tests/outputs/arity.css";s:4:"dfb1";s:58:"Resources/Private/PHP/lessphp/tests/outputs/attributes.css";s:4:"4370";s:56:"Resources/Private/PHP/lessphp/tests/outputs/builtins.css";s:4:"ab01";s:54:"Resources/Private/PHP/lessphp/tests/outputs/colors.css";s:4:"c359";s:64:"Resources/Private/PHP/lessphp/tests/outputs/compile_on_mixin.css";s:4:"2cdb";s:58:"Resources/Private/PHP/lessphp/tests/outputs/directives.css";s:4:"66ba";s:54:"Resources/Private/PHP/lessphp/tests/outputs/escape.css";s:4:"22c9";s:59:"Resources/Private/PHP/lessphp/tests/outputs/font_family.css";s:4:"7a12";s:54:"Resources/Private/PHP/lessphp/tests/outputs/guards.css";s:4:"9c36";s:53:"Resources/Private/PHP/lessphp/tests/outputs/hacks.css";s:4:"313f";s:50:"Resources/Private/PHP/lessphp/tests/outputs/hi.css";s:4:"b28c";s:50:"Resources/Private/PHP/lessphp/tests/outputs/ie.css";s:4:"7c19";s:54:"Resources/Private/PHP/lessphp/tests/outputs/import.css";s:4:"80d5";s:57:"Resources/Private/PHP/lessphp/tests/outputs/keyframes.css";s:4:"72c2";s:52:"Resources/Private/PHP/lessphp/tests/outputs/math.css";s:4:"9962";s:53:"Resources/Private/PHP/lessphp/tests/outputs/media.css";s:4:"8736";s:52:"Resources/Private/PHP/lessphp/tests/outputs/misc.css";s:4:"b407";s:63:"Resources/Private/PHP/lessphp/tests/outputs/mixin_functions.css";s:4:"9604";s:61:"Resources/Private/PHP/lessphp/tests/outputs/mixin_merging.css";s:4:"807f";s:54:"Resources/Private/PHP/lessphp/tests/outputs/mixins.css";s:4:"c4c8";s:54:"Resources/Private/PHP/lessphp/tests/outputs/nested.css";s:4:"8cef";s:55:"Resources/Private/PHP/lessphp/tests/outputs/nesting.css";s:4:"7864";s:64:"Resources/Private/PHP/lessphp/tests/outputs/pattern_matching.css";s:4:"9e87";s:54:"Resources/Private/PHP/lessphp/tests/outputs/scopes.css";s:4:"9829";s:68:"Resources/Private/PHP/lessphp/tests/outputs/selector_expressions.css";s:4:"18f1";s:58:"Resources/Private/PHP/lessphp/tests/outputs/site_demos.css";s:4:"3143";s:57:"Resources/Private/PHP/lessphp/tests/outputs/variables.css";s:4:"4757";s:14:"doc/manual.sxw";s:4:"4986";}',
	'suggests' => array(
	),
);

?>