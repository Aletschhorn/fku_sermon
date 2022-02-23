<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons',
		'label' => 'date',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'notpublic,date,title,preacher,bible_passage,bible_text,concept,related_files,serial,',
		'iconfile' => 'EXT:fku_sermon/Resources/Public/Icons/tx_fkusermon_domain_model_sermons.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, date, title, preacher, bible_passage, bible_text, concept, related_files, serial',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, notpublic, date, title, serial, preacher, bible_passage, bible_text, concept, related_files, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			),
		),

		'notpublic' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.notpublic',
			'config' => array(
				'type' => 'check',
			),
		),
		'date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.date',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'preacher' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.preacher',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bible_passage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.bible_passage',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bible_text' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.bible_text',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'concept' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.concept',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'related_files' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.related_files',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'related_files', 
				array(
					'appearance' => array('createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'),
					'foreign_match_fields' => array('fieldname' => 'related_files', 'tablenames' => 'tx_fkusermon_domain_model_sermons', 'table_local' => 'sys_file')
				)
			)
		),
		'serial' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_sermon/Resources/Private/Language/locallang_db.xlf:tx_fkusermon_domain_model_sermons.serial',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkusermon_domain_model_serials',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		
	),
);