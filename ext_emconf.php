<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ws_less".
 *
 * Auto generated 26-09-2013 22:54
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
	'version' => '1.3.1',
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
			'typo3' => '6.0.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:91:{s:16:"ext_autoload.php";s:4:"f447";s:12:"ext_icon.gif";s:4:"31d4";s:17:"ext_localconf.php";s:4:"be03";s:24:"ext_typoscript_setup.txt";s:4:"b038";s:40:"Classes/Hooks/RenderPreProcessorHook.php";s:4:"7d43";s:43:"Resources/Private/PHP/lessphp/composer.json";s:4:"35dd";s:43:"Resources/Private/PHP/lessphp/lessc.inc.php";s:4:"f62d";s:37:"Resources/Private/PHP/lessphp/lessify";s:4:"e8e8";s:45:"Resources/Private/PHP/lessphp/lessify.inc.php";s:4:"e0c2";s:37:"Resources/Private/PHP/lessphp/LICENSE";s:4:"8d39";s:38:"Resources/Private/PHP/lessphp/Makefile";s:4:"bf73";s:40:"Resources/Private/PHP/lessphp/package.sh";s:4:"a27f";s:36:"Resources/Private/PHP/lessphp/plessc";s:4:"be25";s:39:"Resources/Private/PHP/lessphp/README.md";s:4:"1fae";s:42:"Resources/Private/PHP/lessphp/docs/docs.md";s:4:"c494";s:47:"Resources/Private/PHP/lessphp/tests/ApiTest.php";s:4:"52df";s:48:"Resources/Private/PHP/lessphp/tests/bootstrap.sh";s:4:"1c03";s:49:"Resources/Private/PHP/lessphp/tests/InputTest.php";s:4:"3665";s:45:"Resources/Private/PHP/lessphp/tests/README.md";s:4:"4ac8";s:44:"Resources/Private/PHP/lessphp/tests/sort.php";s:4:"022e";s:65:"Resources/Private/PHP/lessphp/tests/inputs/accessors.less.disable";s:4:"8282";s:53:"Resources/Private/PHP/lessphp/tests/inputs/arity.less";s:4:"a8fd";s:58:"Resources/Private/PHP/lessphp/tests/inputs/attributes.less";s:4:"1cf5";s:56:"Resources/Private/PHP/lessphp/tests/inputs/builtins.less";s:4:"6d5f";s:54:"Resources/Private/PHP/lessphp/tests/inputs/colors.less";s:4:"f308";s:64:"Resources/Private/PHP/lessphp/tests/inputs/compile_on_mixin.less";s:4:"2f93";s:58:"Resources/Private/PHP/lessphp/tests/inputs/directives.less";s:4:"c213";s:54:"Resources/Private/PHP/lessphp/tests/inputs/escape.less";s:4:"1748";s:59:"Resources/Private/PHP/lessphp/tests/inputs/font_family.less";s:4:"9763";s:54:"Resources/Private/PHP/lessphp/tests/inputs/guards.less";s:4:"c926";s:53:"Resources/Private/PHP/lessphp/tests/inputs/hacks.less";s:4:"4227";s:50:"Resources/Private/PHP/lessphp/tests/inputs/hi.less";s:4:"2579";s:50:"Resources/Private/PHP/lessphp/tests/inputs/ie.less";s:4:"b184";s:54:"Resources/Private/PHP/lessphp/tests/inputs/import.less";s:4:"ca14";s:61:"Resources/Private/PHP/lessphp/tests/inputs/interpolation.less";s:4:"130a";s:57:"Resources/Private/PHP/lessphp/tests/inputs/keyframes.less";s:4:"843c";s:52:"Resources/Private/PHP/lessphp/tests/inputs/math.less";s:4:"0b9a";s:53:"Resources/Private/PHP/lessphp/tests/inputs/media.less";s:4:"a89f";s:52:"Resources/Private/PHP/lessphp/tests/inputs/misc.less";s:4:"1470";s:63:"Resources/Private/PHP/lessphp/tests/inputs/mixin_functions.less";s:4:"4d11";s:69:"Resources/Private/PHP/lessphp/tests/inputs/mixin_merging.less.disable";s:4:"2a0b";s:54:"Resources/Private/PHP/lessphp/tests/inputs/mixins.less";s:4:"2751";s:54:"Resources/Private/PHP/lessphp/tests/inputs/nested.less";s:4:"8472";s:64:"Resources/Private/PHP/lessphp/tests/inputs/pattern_matching.less";s:4:"1158";s:54:"Resources/Private/PHP/lessphp/tests/inputs/scopes.less";s:4:"7b89";s:68:"Resources/Private/PHP/lessphp/tests/inputs/selector_expressions.less";s:4:"1345";s:58:"Resources/Private/PHP/lessphp/tests/inputs/site_demos.less";s:4:"4699";s:57:"Resources/Private/PHP/lessphp/tests/inputs/variables.less";s:4:"ada0";s:62:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/a.less";s:4:"8c6f";s:62:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/b.less";s:4:"eb43";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file1.less";s:4:"e904";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file2.less";s:4:"cccf";s:66:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/file3.less";s:4:"936e";s:72:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/inner/file1.less";s:4:"55d8";s:72:"Resources/Private/PHP/lessphp/tests/inputs/test-imports/inner/file2.less";s:4:"88fc";s:66:"Resources/Private/PHP/lessphp/tests/inputs_lessjs/mixins-args.less";s:4:"e2ad";s:72:"Resources/Private/PHP/lessphp/tests/inputs_lessjs/mixins-named-args.less";s:4:"f48f";s:62:"Resources/Private/PHP/lessphp/tests/inputs_lessjs/strings.less";s:4:"d1b4";s:57:"Resources/Private/PHP/lessphp/tests/outputs/accessors.css";s:4:"661e";s:53:"Resources/Private/PHP/lessphp/tests/outputs/arity.css";s:4:"41ef";s:58:"Resources/Private/PHP/lessphp/tests/outputs/attributes.css";s:4:"4370";s:56:"Resources/Private/PHP/lessphp/tests/outputs/builtins.css";s:4:"e712";s:54:"Resources/Private/PHP/lessphp/tests/outputs/colors.css";s:4:"b05b";s:64:"Resources/Private/PHP/lessphp/tests/outputs/compile_on_mixin.css";s:4:"2cdb";s:58:"Resources/Private/PHP/lessphp/tests/outputs/directives.css";s:4:"6833";s:54:"Resources/Private/PHP/lessphp/tests/outputs/escape.css";s:4:"a672";s:59:"Resources/Private/PHP/lessphp/tests/outputs/font_family.css";s:4:"7a12";s:54:"Resources/Private/PHP/lessphp/tests/outputs/guards.css";s:4:"6ba4";s:53:"Resources/Private/PHP/lessphp/tests/outputs/hacks.css";s:4:"313f";s:50:"Resources/Private/PHP/lessphp/tests/outputs/hi.css";s:4:"b28c";s:50:"Resources/Private/PHP/lessphp/tests/outputs/ie.css";s:4:"66ff";s:54:"Resources/Private/PHP/lessphp/tests/outputs/import.css";s:4:"b45e";s:61:"Resources/Private/PHP/lessphp/tests/outputs/interpolation.css";s:4:"5043";s:57:"Resources/Private/PHP/lessphp/tests/outputs/keyframes.css";s:4:"72c2";s:52:"Resources/Private/PHP/lessphp/tests/outputs/math.css";s:4:"1f30";s:53:"Resources/Private/PHP/lessphp/tests/outputs/media.css";s:4:"60fd";s:52:"Resources/Private/PHP/lessphp/tests/outputs/misc.css";s:4:"94a2";s:63:"Resources/Private/PHP/lessphp/tests/outputs/mixin_functions.css";s:4:"3e0a";s:61:"Resources/Private/PHP/lessphp/tests/outputs/mixin_merging.css";s:4:"807f";s:54:"Resources/Private/PHP/lessphp/tests/outputs/mixins.css";s:4:"947a";s:54:"Resources/Private/PHP/lessphp/tests/outputs/nested.css";s:4:"8cef";s:55:"Resources/Private/PHP/lessphp/tests/outputs/nesting.css";s:4:"7864";s:64:"Resources/Private/PHP/lessphp/tests/outputs/pattern_matching.css";s:4:"9e87";s:54:"Resources/Private/PHP/lessphp/tests/outputs/scopes.css";s:4:"9829";s:68:"Resources/Private/PHP/lessphp/tests/outputs/selector_expressions.css";s:4:"2cd3";s:58:"Resources/Private/PHP/lessphp/tests/outputs/site_demos.css";s:4:"3143";s:57:"Resources/Private/PHP/lessphp/tests/outputs/variables.css";s:4:"22a5";s:66:"Resources/Private/PHP/lessphp/tests/outputs_lessjs/mixins-args.css";s:4:"ff2f";s:72:"Resources/Private/PHP/lessphp/tests/outputs_lessjs/mixins-named-args.css";s:4:"a191";s:62:"Resources/Private/PHP/lessphp/tests/outputs_lessjs/strings.css";s:4:"712f";s:14:"doc/manual.sxw";s:4:"6d4c";}',
	'suggests' => array(
	),
);

?>