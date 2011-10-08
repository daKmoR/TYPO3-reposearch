<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Thomas Allmer <at@delusionworld.com>, WEBTEAM GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 *
 *
 * @package reposearch
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Reposearch_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @param string $searchWord the Word to search for
	 * @return void
	 */
	public function searchAction($searchWord) {
		//var_dump($this->settings);
		
		$results = array();
		foreach ($this->settings as $repositoryName => $repositorySettings) {
			$repository = t3lib_div::makeInstance($repositoryName, $repositorySettings['init']);
			if (method_exists($repository, 'setDefaultQuerySettings')) {
				$querySettings = t3lib_div::makeInstance('Tx_Extbase_Persistence_Typo3QuerySettings');
				$querySettings->setStoragePageIds(t3lib_div::intExplode(',', $repositorySettings['persistence']['storagePid']));
				$repository->setDefaultQuerySettings($querySettings);
			}
			$repositoryResults = $repository->findSearchWord($searchWord);
			foreach($repositoryResults as $repositoryResult) { 
				$results[] = array('settings' => $repositorySettings, 'object' => $repositoryResult);
			}
		}
		$this->view->assign('results', $results);
	}


}
?>