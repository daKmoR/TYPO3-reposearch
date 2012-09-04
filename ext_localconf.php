<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Repositorysearch',
	array(
		'Search' => 'form, search',
	),
	// non-cacheable actions
	array(
		'Search' => 'form, search',
	)
);