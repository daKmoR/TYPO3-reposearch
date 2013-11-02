<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'Repositorysearch',
	array(
		'Search' => 'form, search',
	),
	// non-cacheable actions
	array(
		'Search' => 'form, search',
	)
);