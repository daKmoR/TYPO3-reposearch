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
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $navigationTitle;

	/**
	 * @var integer
	 */
	protected $layout;

	/**
	 * @var integer
	 */
	protected $hideInMenu;

	/**
	 * @var integer
	 */
	protected $sorting;

	/**
	 * @var \TYPO3\Reposearch\Domain\Model\Page
	 */
	protected $parent;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Page>
	 */
	protected $children;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Content>
	 */
	protected $contents;

	/**
	 * __construct
	 *
	 * @return \TYPO3\Reposearch\Domain\Model\Page
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->children = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->contents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @return string $navigationTitle
	 */
	public function getNavigationTitle() {
		return $this->navigationTitle;
	}

	/**
	 * @param string $navigationTitle
	 * @return void
	 */
	public function setNavigationTitle($navigationTitle) {
		$this->navigationTitle = $navigationTitle;
	}

	/**
	 * @return integer $layout
	 */
	public function getLayout() {
		return $this->layout;
	}

	/**
	 * @param integer $layout
	 * @return void
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
	}

	/**
	 * @return integer $hideInMenu
	 */
	public function getHideInMenu() {
		return $this->hideInMenu;
	}

	/**
	 * @param integer $hideInMenu
	 * @return void
	 */
	public function setHideInMenu($hideInMenu) {
		$this->hideInMenu = $hideInMenu;
	}

	/**
	 * @return \TYPO3\Reposearch\Domain\Model\Page $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Page $parent
	 * @return void
	 */
	public function setParent(\TYPO3\Reposearch\Domain\Model\Page $parent) {
		$this->parent = $parent;
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Page $subPage
	 * @return void
	 */
	public function addSubPage(\TYPO3\Reposearch\Domain\Model\Page $subPage) {
		$this->children->attach($subPage);
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Page $subPageToRemove The Page to be removed
	 * @return void
	 */
	public function removeSubPage(\TYPO3\Reposearch\Domain\Model\Page $subPageToRemove) {
		$this->children->detach($subPageToRemove);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Page> $children
	 */
	public function getChildren() {
		$children = $this->children->toArray();
		usort($children, array('Page', 'comparePages'));
		return $children;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Page> $children
	 */
	public function getNotHideInMenuChildren() {
		$children = array();
		foreach($this->getChildren() as $child) {
			if ($child->getHideInMenu() !== 1) {
				$children[] = $child;
			}
		}
		return $children;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Page> $children
	 * @return void
	 */
	public function setChildren(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $subPages) {
		$this->children = $subPages;
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Content $content
	 * @return void
	 */
	public function addContent(\TYPO3\Reposearch\Domain\Model\Content $content) {
		$this->contents->attach($content);
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Content $contentToRemove The Content to be removed
	 * @return void
	 */
	public function removeContent(\TYPO3\Reposearch\Domain\Model\Content $contentToRemove) {
		$this->contents->detach($contentToRemove);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Content> $contents
	 */
	public function getContents() {
		return $this->contents;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\Reposearch\Domain\Model\Content> $contents
	 * @return void
	 */
	public function setContents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contents) {
		$this->contents = $contents;
	}

	/**
	 * @param null $colPos
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Content> $contents
	 */
	public function getContentsForColPos($colPos = NULL) {
		if ($colPos >= 0) {
			$contents = $this->getContents();
			$colPosContents = array();
			foreach($contents as $content) {
				if ($content->getColPos() === $colPos) {
					$colPosContents[] = $content;
				}
			}
			return $colPosContents;
		} else {
			return $this->getContents();
		}
	}

	/**
	 * @static
	 * @param \TYPO3\Reposearch\Domain\Model\Page $pageA
	 * @param \TYPO3\Reposearch\Domain\Model\Page $pageB
	 * @return int
	 */
	static function comparePages(\TYPO3\Reposearch\Domain\Model\Page $pageA, \TYPO3\Reposearch\Domain\Model\Page $pageB)	{
		$pageASorting = strtolower($pageA->getSorting());
		$pageBSorting = strtolower($pageB->getSorting());
		if ($pageASorting == $pageBSorting) {
			return 0;
		}
		return ($pageASorting > $pageBSorting) ? +1 : -1;
	}

	/**
	 * @param int $sorting
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}

	/**
	 * @return int
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * @param \TYPO3\Reposearch\Domain\Model\Page $after
	 */
	public function moveAfter(\TYPO3\Reposearch\Domain\Model\Page $after) {
		$cmd['pages'][$this->getUid()]['move'] = $after->getUid() * -1;
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->stripslashes_values = 0;
		$tce->start(array(), $cmd);
		$tce->process_cmdmap();
	}

	/**
	 * @return string
	 */
	public function getText() {
		$text = '';
		foreach($this->getContents() as $content) {
			if (method_exists($content, 'getText')) {
				$text .= $content->getText() . ' ';
			}
		}
		return $text;
	}

}