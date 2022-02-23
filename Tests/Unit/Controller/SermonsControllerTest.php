<?php
namespace FKU\FkuSermon\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Widmer <daniel.widmer@fku.ch>
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class FKU\FkuSermon\Controller\SermonsController.
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class SermonsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \FKU\FkuSermon\Controller\SermonsController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('FKU\\FkuSermon\\Controller\\SermonsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllSermonssFromRepositoryAndAssignsThemToView() {

		$allSermonss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$sermonsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SermonsRepository', array('findAll'), array(), '', FALSE);
		$sermonsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allSermonss));
		$this->inject($this->subject, 'sermonsRepository', $sermonsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('sermonss', $allSermonss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenSermonsToView() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('sermons', $sermons);

		$this->subject->showAction($sermons);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenSermonsToView() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newSermons', $sermons);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($sermons);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenSermonsToSermonsRepository() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$sermonsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SermonsRepository', array('add'), array(), '', FALSE);
		$sermonsRepository->expects($this->once())->method('add')->with($sermons);
		$this->inject($this->subject, 'sermonsRepository', $sermonsRepository);

		$this->subject->createAction($sermons);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenSermonsToView() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('sermons', $sermons);

		$this->subject->editAction($sermons);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenSermonsInSermonsRepository() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$sermonsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SermonsRepository', array('update'), array(), '', FALSE);
		$sermonsRepository->expects($this->once())->method('update')->with($sermons);
		$this->inject($this->subject, 'sermonsRepository', $sermonsRepository);

		$this->subject->updateAction($sermons);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenSermonsFromSermonsRepository() {
		$sermons = new \FKU\FkuSermon\Domain\Model\Sermons();

		$sermonsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SermonsRepository', array('remove'), array(), '', FALSE);
		$sermonsRepository->expects($this->once())->method('remove')->with($sermons);
		$this->inject($this->subject, 'sermonsRepository', $sermonsRepository);

		$this->subject->deleteAction($sermons);
	}
}
