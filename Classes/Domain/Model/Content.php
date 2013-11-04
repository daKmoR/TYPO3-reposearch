<?php
namespace TYPO3\Reposearch\Domain\Model;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var integer
	 */
	protected $hidden;

	/**
	 * @var \TYPO3\Reposearch\Domain\Model\Page
	 */
	protected $page;

	/**
	 * @var integer
	 */
	protected $colPos;

	/**
	 * @var string
	 */
	protected $text;

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
	 * @return integer $hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * @param integer $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * @return \TYPO3\Reposearch\Domain\Model\Page $page
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Page $page
	 * @return void
	 */
	public function setPage(\TYPO3\Reposearch\Domain\Model\Page $page) {
		$this->page = $page;
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
	 * @param int $colPos
	 */
	public function setColPos($colPos) {
		$this->colPos = $colPos;
	}

	/**
	 * @return int
	 */
	public function getColPos() {
		return $this->colPos;
	}

	/**
	 * @param Content $after
	 */
	public function moveAfter(Content $after) {
		$cmd['tt_content'][$this->getUid()]['move'] = $after->getUid() * -1;
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->stripslashes_values = 0;
		$tce->start(array(), $cmd);
		$tce->process_cmdmap();
	}

}