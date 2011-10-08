<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Repositorysearch',
	array(
		'Search' => 'search, list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Search' => 'create, update, delete',
		
	)
);

?>