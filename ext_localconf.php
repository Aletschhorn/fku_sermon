<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'FKU.fku_sermon',
	'Sermons',
	array(
		'Sermons' => 'list, listSerial, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Sermons' => 'list, create, update, delete',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'FKU.fku_sermon',
	'Serials',
	array(
		'Serials' => 'list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Serials' => 'create, update, delete',
		
	)
);
