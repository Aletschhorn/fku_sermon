<?php
namespace FKU\FkuSermon\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Daniel Widmer <daniel.widmer@fku.ch>
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
 * The repository for Sermons
 */
class SermonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	/**
	* defaultOrderings
	*
	* @var array
	*/
	protected $defaultOrderings = array('date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
	
	/**
	* findByDate
	*
	* @return
	*/
	public function findByDate() {

/*		$oldest = mktime(0,0,0,1,1,2013);
		$query = $this->createQuery();
		$result = $query->matching(
			$query->greaterThanOrEqual('date',$oldest)
		)->execute();
*/
		$query = $this->createQuery();
		$result = $query->execute();
		return $result;
	}

	/**
	* findBySearch
	*
	* @var String $expression
	* @var Integer $year 0 = all years (no limitation)
	* @return
	*/
	public function findBySearch($expression = '', $year = 0) {
		$query = $this->createQuery();
		if ($year == 0) {
			if ($expression) {
				$query->matching($query->logicalOr(
					$query->like('title','%'.$expression.'%'),
					$query->like('biblePassage','%'.$expression.'%')
				));
			}
		} else {
			$start = mktime(0,0,0,1,1,$year);
			$end = mktime(0,0,0,1,1,$year+1);
			if ($expression) {
				$query->matching($query->logicalAnd(
					$query->logicalOr(
						$query->like('title','%'.$expression.'%'),
						$query->like('biblePassage','%'.$expression.'%')
					),
					$query->greaterThanOrEqual('date',$start),
					$query->lessThan('date',$end)
				));				
			} else {
				$query->matching($query->logicalAnd(
					$query->greaterThanOrEqual('date',$start),
					$query->lessThan('date',$end)
				));				
			}
		}
		$query->setOrderings(array('date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute();
	}

	/**
	* findBySerial
	*
	* @return
	*/
	public function findBySerial() {
		$oldest = mktime(0,0,0,1,1,2013);
		$query = $this->createQuery();
		$query->matching($query->greaterThanOrEqual('date',$oldest));
		$query->setOrderings(array('serial.sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING, 'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute();
	}

	/**
	* findOldest
	*
	* @return
	*/
	public function findOldest() {
		$query = $this->createQuery();
		$query->setOrderings(array('date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		return $query->execute()->getFirst();
	}
	
	/**
	* findNewest
	*
	* @var boolean $onlyPublic
	* @return
	*/
	public function findNewest($onlyPublic = false) {
		$query = $this->createQuery();
		if ($onlyPublic) {
			$query->matching($query->equals('notpublic',0));
		}
		$query->setOrderings(array('date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute()->getFirst();
	}
	
}