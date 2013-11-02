<?php
namespace TYPO3\Reposearch\Domain\Repository;

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
class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @param $pid
	 * @param $colPos
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
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