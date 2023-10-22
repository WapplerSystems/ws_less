<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ws_less".
 *
 * Auto generated 07-02-2014 02:04
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF['ws_less'] = [
    'title' => 'LESS compiler for TYPO3',
    'description' => 'Compiles LESS files to CSS files.',
    'category' => 'fe',
    'shy' => 0,
    'version' => '12.0.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => 'typo3temp/ws_less',
    'modify_tables' => '',
    'clearcacheonload' => true,
    'lockType' => '',
    'author' => 'Sven Wappler',
    'author_email' => 'typo3@wappler.systems',
    'author_company' => 'WapplerSystems',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'php' => '8.0.0-8.2.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'suggests' => [],
];
