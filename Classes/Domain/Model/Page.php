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
 * Page
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Reposearch_Domain_Model_Page extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string $name
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * @var string $navigationTitle
	 */
	protected $navigationTitle;

	/**
	 * @var integer $sorting
	 */
	protected $sorting;

	/**
	 * @var integer $start
	 */
	protected $start;

	/**
	 * @var integer $end
	 */
	protected $end;

	/**
	 * @var integer $layout
	 */
	protected $layout;

	/**
	 * @var integer $hideInMenu
	 */
	protected $hideInMenu;

	/**
	 * @var Tx_Reposearch_Domain_Model_Page $parent
	 */
	protected $parent;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Reposearch_Domain_Model_Page>
	 */
	protected $subPages;
	
	/**
	 * @var string $state
	 */
	protected $state;
	
	/**
	 * @return void
	 */
	public function __construct() {
		$this->subPages = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param Tx_Reposearch_Domain_Model_Page $subPage
	 * @return void
	 */
	public function addSubPage(Tx_Reposearch_Domain_Model_Page $subPage) {
		$this->subPages->attach($subPages);
	}

	/**
	 * @param Tx_Reposearch_Domain_Model_Page $subPageToRemove The SubPages to be removed
	 * @return void
	 */
	public function removeSubPage(Tx_Reposearch_Domain_Model_Page $subPageToRemove) {
		$this->subPages->detach($subPageToRemove);
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Reposearch_Domain_Model_Page> $subPages
	 */
	public function getSubPages() {
		return $this->subPages;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Reposearch_Domain_Model_Page> $subPages
	 * @return void
	 */
	public function setSubPages($subPages) {
		$this->subPages = $subPages;
	}

	/**
	 * @param string $name name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return string name
	 */
	public function getText() {
		return $this->name;
	}	

	/**
	 * Setter for navigationTitle
	 *
	 * @param string $navigationTitle navigationTitle
	 * @return void
	 */
	public function setNavigationTitle($navigationTitle) {
		$this->navigationTitle = $navigationTitle;
	}

	/**
	 * Getter for navigationTitle
	 *
	 * @return string navigationTitle
	 */
	public function getNavigationTitle() {
		return $this->navigationTitle;
	}

	/**
	 * Setter for sorting
	 *
	 * @param integer $sorting sorting
	 * @return void
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}

	/**
	 * Getter for sorting
	 *
	 * @return integer sorting
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * Setter for start
	 *
	 * @param integer $start start
	 * @return void
	 */
	public function setStart($start) {
		$this->start = $start;
	}

	/**
	 * Getter for start
	 *
	 * @return integer start
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Setter for end
	 *
	 * @param integer $end end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
	}

	/**
	 * Getter for end
	 *
	 * @return integer end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Setter for layout
	 *
	 * @param integer $layout layout
	 * @return void
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
	}

	/**
	 * Getter for layout
	 *
	 * @return integer layout
	 */
	public function getLayout() {
		return $this->layout;
	}

	/**
	 * Setter for hideInMenu
	 *
	 * @param integer $hideInMenu hideInMenu
	 * @return void
	 */
	public function setHideInMenu($hideInMenu) {
		$this->hideInMenu = $hideInMenu;
	}

	/**
	 * Getter for hideInMenu
	 *
	 * @return integer hideInMenu
	 */
	public function getHideInMenu() {
		return $this->hideInMenu;
	}

	/**
	 * Setter for parent
	 *
	 * @param Tx_Reposearch_Domain_Model_Page $parent parent
	 * @return void
	 */
	public function setParent(Tx_Reposearch_Domain_Model_Page $parent) {
		$this->parent = $parent;
	}

	/**
	 * Getter for parent
	 *
	 * @return Tx_Reposearch_Domain_Model_Page parent
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * @param string $state
	 * @return void
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * @return string state
	 */
	public function getState() {
		return $this->state;
	}

}
?>