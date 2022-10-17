<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'fku_sermon',
	'List',
	'Sermons'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'fku_sermon',
	'Last',
	'Latest sermon'
);
