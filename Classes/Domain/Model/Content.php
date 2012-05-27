<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 
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
class Tx_Reposearch_Domain_Model_Content extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $text;

	/**
	 * @var Tx_Reposearch_Domain_Model_Page
	 */
	protected $page;

	/**
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * @return Tx_Reposearch_Domain_Model_Page
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @param Tx_Reposearch_Domain_Model_Page
	 * @return void
	 */
	public function setPage(Tx_Extbase_Persistence_ObjectStorage $page) {
		$this->page = $page;
	}

}
?>