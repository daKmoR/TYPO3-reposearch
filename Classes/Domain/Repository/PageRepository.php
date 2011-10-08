<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Thomas Allmer <at@delusionworld.com>
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
 * Repository for Tx_Easyedit_Domain_Model_Page
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
 
class Tx_Reposearch_Domain_Repository_PageRepository extends Tx_Extbase_Persistence_Repository {

	
	/**
	 * Gets a tree of pages
	 *
	 * @var integer $startUid
	 * @var integer $currentUid
	 * @return array Tree of Pages
	 */
	public function getTreeFromId($startUid, $currentUid = NULL) {
		$query = $this->createQuery();
		$constraints = array();
		$constraints[] = $query->equals('pid', $startUid);
		
		if (count($constraints) > 0) {
			$query->matching($query->logicalAnd($constraints));
		}
		
		$pages = $query->execute();
		foreach($pages as $id => $page) {
			$subPages = $this->getTreeFromId($page->getUid(), $currentUid);
			foreach($subPages as $subPage) {
				$subPage->setParent($page);
			}
			$pages[$id]->setSubPages($subPages);
			
			if ($page->getUid() === $currentUid) {
				$page->setState('current');
				
				$tmpPage = $page;
				while ($parent = $tmpPage->getParent()) {
					$parent->setState('active');
					$tmpPage = $parent;
				}
			}
		}
		return $pages;
	}
	
	/**
	 * Gets a tree of pages
	 *
	 * @var string $searchWord 
	 * @return array Tree of Pages
	 */	
	public function findSearchWord($searchWord) {
		$query = $this->createQuery();
		$constraints = array();
		
		$searchWordConstraints = array();
		$propertiesToSearch = array('name', 'contents.name', 'contents.text');
		$propertiesToSearch = array('name');
		foreach ($propertiesToSearch as $propertyName) {
			$searchWordConstraints[] = $query->like($propertyName, '%' . $searchWord . '%');
		}
		$constraints[] = $query->logicalOr($searchWordConstraints);
		
		if (count($constraints) > 0) {
			$query->matching($query->logicalAnd($constraints));
		}
		return $query->execute();
	}

}
?>