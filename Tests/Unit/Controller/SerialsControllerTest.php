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
 * Test case for class FKU\FkuSermon\Controller\SerialsController.
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class SerialsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \FKU\FkuSermon\Controller\SerialsController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('FKU\\FkuSermon\\Controller\\SerialsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllSerialssFromRepositoryAndAssignsThemToView() {

		$allSerialss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$serialsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SerialsRepository', array('findAll'), array(), '', FALSE);
		$serialsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allSerialss));
		$this->inject($this->subject, 'serialsRepository', $serialsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('serialss', $allSerialss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenSerialsToView() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('serials', $serials);

		$this->subject->showAction($serials);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenSerialsToView() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newSerials', $serials);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($serials);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenSerialsToSerialsRepository() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$serialsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SerialsRepository', array('add'), array(), '', FALSE);
		$serialsRepository->expects($this->once())->method('add')->with($serials);
		$this->inject($this->subject, 'serialsRepository', $serialsRepository);

		$this->subject->createAction($serials);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenSerialsToView() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('serials', $serials);

		$this->subject->editAction($serials);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenSerialsInSerialsRepository() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$serialsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SerialsRepository', array('update'), array(), '', FALSE);
		$serialsRepository->expects($this->once())->method('update')->with($serials);
		$this->inject($this->subject, 'serialsRepository', $serialsRepository);

		$this->subject->updateAction($serials);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenSerialsFromSerialsRepository() {
		$serials = new \FKU\FkuSermon\Domain\Model\Serials();

		$serialsRepository = $this->getMock('FKU\\FkuSermon\\Domain\\Repository\\SerialsRepository', array('remove'), array(), '', FALSE);
		$serialsRepository->expects($this->once())->method('remove')->with($serials);
		$this->inject($this->subject, 'serialsRepository', $serialsRepository);

		$this->subject->deleteAction($serials);
	}
}
