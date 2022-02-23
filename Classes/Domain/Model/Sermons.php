<?php
namespace FKU\FkuSermon\Domain\Model;


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
 * Sermons
 */
class Sermons extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * date
	 *
	 * @var \DateTime
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $date = NULL;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * preacher
	 *
	 * @var string
	 */
	protected $preacher = '';

	/**
	 * biblePassage
	 *
	 * @var string
	 */
	protected $biblePassage = '';

	/**
	 * bibleText
	 *
	 * @var string
	 */
	protected $bibleText = '';

	/**
	 * concept
	 *
	 * @var string
	 */
	protected $concept = '';

	/**
	 * relatedFiles
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $relatedFiles = NULL;

	/**
	 * serial
	 *
	 * @var \FKU\FkuSermon\Domain\Model\Serials
	 */
	protected $serial = NULL;

	/**
	 * notpublic
	 *
	 * @var boolean
	 */
	protected $notpublic = 0;

	/**
	 * __construct
	 *
	 * @return Event
	 */
	public function __construct() {

		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->relatedFiles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the date
	 *
	 * @return \DateTime $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the date
	 *
	 * @param \DateTime $date
	 * @return void
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the preacher
	 *
	 * @return string $preacher
	 */
	public function getPreacher() {
		return $this->preacher;
	}

	/**
	 * Sets the preacher
	 *
	 * @param string $preacher
	 * @return void
	 */
	public function setPreacher($preacher) {
		$this->preacher = $preacher;
	}

	/**
	 * Returns the biblePassage
	 *
	 * @return string $biblePassage
	 */
	public function getBiblePassage() {
		return $this->biblePassage;
	}

	/**
	 * Sets the biblePassage
	 *
	 * @param string $biblePassage
	 * @return void
	 */
	public function setBiblePassage($biblePassage) {
		$this->biblePassage = $biblePassage;
	}

	/**
	 * Returns the bibleText
	 *
	 * @return string $bibleText
	 */
	public function getBibleText() {
		return $this->bibleText;
	}

	/**
	 * Sets the bibleText
	 *
	 * @param string $bibleText
	 * @return void
	 */
	public function setBibleText($bibleText) {
		$this->bibleText = $bibleText;
	}

	/**
	 * Returns the concept
	 *
	 * @return string $concept
	 */
	public function getConcept() {
		return $this->concept;
	}

	/**
	 * Sets the concept
	 *
	 * @param string $concept
	 * @return void
	 */
	public function setConcept($concept) {
		$this->concept = $concept;
	}

	/**
	 * Returns the relatedFiles
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuSermon\Domain\Model\FileReference> $relatedFiles
	 */
	public function getRelatedFiles() {
		return $this->relatedFiles;
	}

	/**
	 * Sets the relatedFiles
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuSermon\Domain\Model\FileReference> $relatedFiles
	 * @return void
	 */
	public function setRelatedFiles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedFiles) {
		$this->relatedFiles = $relatedFiles;
	}

	/**
	 * Adds a relatedFile
	 *
	 * @param \FKU\FkuSermon\Domain\Model\FileReference $relatedFile
	 * @return void
	 */
	public function addRelatedFile(\FKU\FkuSermon\Domain\Model\FileReference $relatedFile) {
		$this->relatedFiles->attach($relatedFile);
	}

	/**
	 * Removes a relatedFile
	 *
	 * @param \FKU\FkuSermon\Domain\Model\FileReference $relatedFile
	 * @return void
	 */
	public function removeRelatedFile(\FKU\FkuSermon\Domain\Model\FileReference $relatedFile) {
		$this->relatedFiles->detach($relatedFile);
	}

	/**
	 * Returns the serial
	 *
	 * @return \FKU\FkuSermon\Domain\Model\Serials $serial
	 */
	public function getSerial() {
		return $this->serial;
	}

	/**
	 * Sets the serial
	 *
	 * @param \FKU\FkuSermon\Domain\Model\Serials $serial
	 * @return void
	 */
	public function setSerial(\FKU\FkuSermon\Domain\Model\Serials $serial) {
		$this->serial = $serial;
	}

	/**
	 * Returns the notpublic
	 *
	 * @return boolean $notpublic
	 */
	public function getNotpublic() {
		return $this->notpublic;
	}

	/**
	 * Sets the notpublic
	 *
	 * @param boolean $notpublic
	 * @return void
	 */
	public function setNotpublic($notpublic) {
		$this->notpublic = $notpublic;
	}

}