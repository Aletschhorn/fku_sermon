<?php

namespace FKU\FkuSermon\Tests\Unit\Domain\Model;

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
 * Test case for class \FKU\FkuSermon\Domain\Model\Sermons.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class SermonsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \FKU\FkuSermon\Domain\Model\Sermons
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \FKU\FkuSermon\Domain\Model\Sermons();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForDateTimeSetsDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'date',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPreacherReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPreacher()
		);
	}

	/**
	 * @test
	 */
	public function setPreacherForStringSetsPreacher() {
		$this->subject->setPreacher('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'preacher',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBiblePassageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getBiblePassage()
		);
	}

	/**
	 * @test
	 */
	public function setBiblePassageForStringSetsBiblePassage() {
		$this->subject->setBiblePassage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'biblePassage',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBibleTextReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getBibleText()
		);
	}

	/**
	 * @test
	 */
	public function setBibleTextForStringSetsBibleText() {
		$this->subject->setBibleText('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'bibleText',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getConceptReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getConcept()
		);
	}

	/**
	 * @test
	 */
	public function setConceptForStringSetsConcept() {
		$this->subject->setConcept('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'concept',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRelatedFilesReturnsInitialValueForFileReference() {
		$this->assertEquals(
			NULL,
			$this->subject->getRelatedFiles()
		);
	}

	/**
	 * @test
	 */
	public function setRelatedFilesForFileReferenceSetsRelatedFiles() {
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setRelatedFiles($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'relatedFiles',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSerialReturnsInitialValueForSerials() {
		$this->assertEquals(
			NULL,
			$this->subject->getSerial()
		);
	}

	/**
	 * @test
	 */
	public function setSerialForSerialsSetsSerial() {
		$serialFixture = new \FKU\FkuSermon\Domain\Model\Serials();
		$this->subject->setSerial($serialFixture);

		$this->assertAttributeEquals(
			$serialFixture,
			'serial',
			$this->subject
		);
	}
}
