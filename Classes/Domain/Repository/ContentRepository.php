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
 
class Tx_Reposearch_Domain_Repository_ContentRepository extends Tx_Extbase_Persistence_Repository {

	
	/**
	 * Searches for the given searchWord
	 *
	 * @var string $searchWord 
	 * @return array Tree of Pages
	 */	
	public function findSearchWord($searchWord) {
		$query = $this->createQuery();
		$constraints = array();
		
		$searchWordConstraints = array();
		$propertiesToSearch = array('name', 'text');
		foreach ($propertiesToSearch as $propertyName) {
			$searchWordConstraints[] = $query->like($propertyName, '%' . $searchWord . '%');
		}
		$constraints[] = $query->logicalOr($searchWordConstraints);
		
		if (count($constraints) > 0) {
			$query->matching($query->logicalAnd($constraints));
		}
		return $query->execute();
	}
	
	public function findByPidAndColPos($pid, $colPos) {
		$query = $this->createQuery();
		$constraints = array();
		
		$constraints[] = $query->equals('pid', $pid);
		$constraints[] = $query->equals('colPos', $colPos);
		
		if (count($constraints) > 0) {
			$query->matching($query->logicalAnd($constraints));
		}
		return $query->execute();
	
	}

}
?>