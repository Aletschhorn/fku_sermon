<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'fku_sermon',
	'Sermons',
	'Sermons'
);

// register flexform
$pluginSignature = 'fkusermon_sermons'; 
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key'; 
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:fku_sermon/Configuration/FlexForms/flexform.xml'); 

?>