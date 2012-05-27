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
	 * @var	tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	/**
	 * @param string $searchWord the Word to search for
	 * @return void
	 */
	public function searchAction($searchWord) {
		$this->settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		ksort($this->settings);
		
		$results = array();
		foreach ($this->settings as $repositoryName => $repositorySettings) {
			$repositoryName = $repositorySettings['_typoScriptNodeValue'];
			$repository = t3lib_div::makeInstance($repositoryName, $repositorySettings['init'], $repositorySettings['settings']);
			if (method_exists($repository, 'setDefaultQuerySettings')) {
				$querySettings = t3lib_div::makeInstance('Tx_Extbase_Persistence_Typo3QuerySettings');
				
				// copied from Tx_Extbase_Configuration_FrontendConfigurationManager
				$pages = $repositorySettings['persistence']['storagePid'];
				$list = array();
				if($repositorySettings['persistence']['recursive'] > 0) {
					$explodedPages = t3lib_div::trimExplode(',', $pages);
					foreach($explodedPages as $pid) {
						$list[] = trim($this->contentObject->getTreeList($pid, $repositorySettings['persistence']['recursive']), ',');
					}
				}
				if (count($list) > 0) {
					$pages = $pages . ',' . implode(',', $list);
				}
				// copy end :p
				
				$querySettings->setStoragePageIds(t3lib_div::intExplode(',', $pages));
				$repository->setDefaultQuerySettings($querySettings);
			}
			$repositoryResults = $repository->findSearchWord($searchWord);
			foreach($repositoryResults as $repositoryResult) {
				$currentRepositorySettings = $repositorySettings;
				if (!is_numeric($repositorySettings['link']['pageUid'])) {
					$currentRepositorySettings['link']['pageUid'] = $repositoryResult->$repositorySettings['link']['pageUid']();
				}
				$resultId = $repositorySettings['groupBy'] ? $repositoryResult->$repositorySettings['groupBy']() : NULL;
				
				if ($repositorySettings['override']['set'] && $repositorySettings['override']['get']) {
					$repositoryResult = clone $repositoryResult;
					$getOverride = t3lib_div::trimExplode(',', $repositorySettings['override']['get']);
					$overrideValue = $repositoryResult;
					foreach($getOverride as $functionName) {
						$overrideValue = $overrideValue->$functionName();
					}
					$repositoryResult->$repositorySettings['override']['set']($overrideValue);
				}
				
				if ($resultId === NULL) {
					$results[] = array('settings' => $currentRepositorySettings, 'object' => $repositoryResult);
				} else {
					$results[$resultId] = array('settings' => $currentRepositorySettings, 'object' => $repositoryResult);
				}
			}
		}
		
		$this->view->assign('results', $results);
		$this->view->assign('searchWord', $searchWord);
	}

}
?>