<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fku_sermon', 'Configuration/TypoScript', 'FKU Sermon');

foreach (['sermons', 'serials'] as $table) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fkusermon_domain_model_' . $table);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fkusermon_domain_model_' . $table, 
	'EXT:fku_sermon/Resources/Private/Language/locallang_csh_tx_fkusermon_domain_model_' . $table . '.xlf');
}

?>