<?php
namespace TYPO3\Reposearch\Controller;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */


/**
 *
 *
 * @package reposearch
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class SearchController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var	\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
	}

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 * @inject
	 */
	protected $objectManager;

	/**
	 *
	 */
	public function formAction() {
		// nothing to do here :p
	}

	/**
	 * @param string $searchWord the Word to search for
	 * @return void
	 */
	public function searchAction($searchWord) {
		$this->settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		ksort($this->settings);

		$results = array();
		foreach ($this->settings as $repositoryName => $repositorySettings) {
			$repositoryName = $repositorySettings['_typoScriptNodeValue'];

			//$repository = t3lib_div::makeInstance($repositoryName, $repositorySettings['init'], $repositorySettings['settings']);
			$repository = $this->objectManager->get($repositoryName);

			if (method_exists($repository, 'setDefaultQuerySettings')) {
				$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

				// copied from Tx_Extbase_Configuration_FrontendConfigurationManager
				$pages = $repositorySettings['persistence']['storagePid'];
				$list = array();
				if($repositorySettings['persistence']['recursive'] > 0) {
					$explodedPages = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $pages);
					foreach($explodedPages as $pid) {
						$list[] = trim($this->contentObject->getTreeList($pid, $repositorySettings['persistence']['recursive']), ',');
					}
				}
				if (count($list) > 0) {
					$pages = $pages . ',' . implode(',', $list);
				}
				// copy end :p

				$querySettings->setStoragePageIds(\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $pages));
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
					$getOverride = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $repositorySettings['override']['get']);
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