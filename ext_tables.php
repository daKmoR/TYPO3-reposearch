<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Repositorysearch',
	'Repository Search'
);

//$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . repositorysearch;
//$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .repositorysearch. '.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Repository Search');

$TCA['pages']['columns']['contents'] = array(
	'exclude' => 0,
	'label' => 'Contents',
	'config' => array(
		'type' => 'inline',
		'foreign_table' => 'tt_content',
		'foreign_field' => 'pid'
	),
);

$TCA['pages']['columns']['children'] = array(
	'exclude' => 0,
	'label' => 'Children',
	'config' => array(
		'type' => 'inline',
		'foreign_table' => 'pages',
		'foreign_field' => 'pid'
	),
);