<?php
use FKU\FkuSermon\Controller\SermonsController;

defined('TYPO3_MODE') or die();

(static function() {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuSermon',
		'List',
		[SermonsController::class => 'list, show, new, create, edit, update, delete'],
		[SermonsController::class => 'list, new, create, edit, update, delete']
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuSermon',
		'Last',
		[SermonsController::class => 'last'],
		[]
	);
})();
