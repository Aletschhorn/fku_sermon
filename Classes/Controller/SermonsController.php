<?php
namespace FKU\FkuSermon\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use FKU\FkuSermon\Domain\Repository\SermonsRepository;
use FKU\FkuSermon\Domain\Repository\SerialsRepository;
use FKU\FkuSermon\Domain\Repository\FileReferenceRepository;
use FKU\FkuSermon\Domain\Model\Sermons;
use FKU\FkuAgenda\Domain\Repository\EventRepository;
use FKU\FkuPeople\Domain\Repository\NotificationRepository;
use FKU\FkuPeople\Command\NotificationCommand;


class SermonsController extends ActionController {

	protected $sermonsRepository;

	protected $serialsRepository;

	protected $fileReferenceRepository;

	protected $eventRepository;

	protected $notificationRepository;

	protected $notificationCommand;
    
	/**
	 * @param SermonsRepository $sermonsRepository
	 * @param SerialsRepository $serialsRepository
	 * @param FileReferenceRepository $fileReferenceRepository
	 * @param EventRepository $eventRepository
	 * @param NotificationRepository $notificationRepository
	 * @param NotificationCommand $notificationCommand
	 */
	public function __construct(
			SermonsRepository $sermonsRepository,
			SerialsRepository $serialsRepository,
			FileReferenceRepository $fileReferenceRepository,
			EventRepository $eventRepository,
			NotificationRepository $notificationRepository,
			NotificationCommand $notificationCommand
		) {
		$this->sermonsRepository = $sermonsRepository;
		$this->serialsRepository = $serialsRepository;
		$this->fileReferenceRepository = $fileReferenceRepository;
		$this->eventRepository = $eventRepository;
		$this->notificationRepository = $notificationRepository;
		$this->notificationCommand = $notificationCommand;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$years = array();
		$old = $this->sermonsRepository->findOldest()->getDate();
		$oldest = $this->sermonsRepository->findOldest()->getDate()->format('Y');
		$newest = $this->sermonsRepository->findNewest()->getDate()->format('Y');
		for ($i=$newest; $i>=$oldest; $i--) {
			$years[$i] = $i;
		}

		if ($this->request->hasArgument('expression')) { 
			$expression = trim($this->request->getArgument('expression')); 
		} else { 
			$expression = '';
		}
		if ($this->request->hasArgument('year')) { 
			$year = intval($this->request->getArgument('year')); 
		} else { 
			$year = reset($years);
		}
		if ($this->request->hasArgument('sorting')) { 
			$sorting = intval($this->request->getArgument('sorting')); 
		} else { 
			$sorting = 1;
		}

		$filter = array(
			'expression' => $expression,
			'year' => $year,
			'sorting' => $sorting
		);

		$sermons = $this->sermonsRepository->findBySearch($expression, $year, $sorting);
		$this->view->assignMultiple(array(
			'sermons' => $sermons,
			'back' => 'list',
			'years' => $years,
			'filter' => $filter,
			'settings' => $this->settings,
		));
	}

	/**
	 * action listSerial
	 *
	 * @return void
	 */
	public function listSerialAction() {
		$sermons = $this->sermonsRepository->findBySerial();
		$this->view->assign('sermons', $sermons);
		$this->view->assign('back', 'listSerial');
	}

	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction(Sermons $sermon) {
		if ($this->request->hasArgument('expression')) { 
			$expression = trim($this->request->getArgument('expression')); 
		} else { 
			$expression = '';
		}
		if ($this->request->hasArgument('year')) { 
			$year = intval($this->request->getArgument('year')); 
		} else { 
			$year = date('Y');
		}
		if ($this->request->hasArgument('sorting')) { 
			$sorting = intval($this->request->getArgument('sorting')); 
		} else { 
			$sorting = 1;
		}
		$this->view->assignMultiple(array(
			'sermon' => $sermon,
			'expression' => $expression,
			'year' => $year,
			'sorting' => $sorting,
			'settings' => $this->settings,
		));
	}

	/**
	 * action last
	 *
	 * @return void
	 */
	public function lastAction() {
		$sermon = $this->sermonsRepository->findNewest(true);
		$this->view->assignMultiple(array(
			'sermon' => $sermon,
			'settings' => $this->settings,
		));
	}

	/**
	 * action new
	 *
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("sermon")
	 * @return void
	 */
	public function newAction(Sermons $sermon = NULL) {
		$sermon = new \FKU\FkuSermon\Domain\Model\Sermons;
		$sermon->setNotpublic(1);
		$last = $this->eventRepository->findLast(1, array($this->settings['agendaSermonVisibilityUid']), 0, array($this->settings['agendaSermonCategoryUid']),1);
		if ($last) {
			$lastSermon = $last[0];
			$sermon->setDate($lastSermon->getEventStart());
			$description = $lastSermon->getDescription();
			if (preg_match('/Predigt:[\s]*(.+)/', $description, $result)) {
				$sermon->setPreacher($result[1]);
			}
			if (preg_match('/Thema:[\s]*"(.+)",[\s]*(.+)/', $description, $result)) {
				$sermon->setTitle($result[1]);
				$sermon->setBiblePassage($result[2]);
			}
		}

		$serials = $this->serialsRepository->findRecent();
		$this->view->assign('serials', $serials);
		$this->view->assign('sermon', $sermon);
	}

	/**
	* initializeCrateAction
	*
	* @return void
	*/
	public function initializeCreateAction() {
		if (isset($this->arguments['sermon'])) {
			$this->arguments['sermon']->getPropertyMappingConfiguration()->forProperty('date')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		}
	}
	
	/**
	 * action create
	 *
	 * @return void
	 */
	public function createAction(Sermons $sermon) {
		
		if ($sermon->getTitle() == '') {
			$sermon->setTitle('(kein Titel)');
		}

		// upload and assign new file
		$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
		$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
		if (count($_FILES['tx_fkusermon_sermons']['error'])) {
			foreach ($_FILES['tx_fkusermon_sermons']['error'] as $fileId => $error) {
				if ($error == UPLOAD_ERR_OK) {
					
					// upload file
					$fileStoreName = 'PD'.$sermon->getDate()->format('ymd').'_'.substr(uniqid(''),5,6).'.'.pathinfo($_FILES['tx_fkusermon_sermons']['name'][$fileId], PATHINFO_EXTENSION);
					$fileTempName = $_FILES['tx_fkusermon_sermons']['tmp_name'][$fileId];
					$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
					$fileRef = new \FKU\FkuSermon\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$sermon->addRelatedFile($fileRef);
				}
			}
		}

		// write to database
		$this->sermonsRepository->add($sermon);
		$this->addFlashMessage('Die Predigt-Angaben wurden gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		
		// Generate notifications as per user-specific rules
		if ($sermon->getNotpublic() == false) {
			$this->generateNotifications($sermon);
		}
		
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("sermon")
	 * @return void
	 */
	public function editAction(Sermons $sermon) {
		$serials = $this->serialsRepository->findAll();
		$this->view->assign('sermon', $sermon);
		$this->view->assign('serials', $serials);
	}

	/**
	* initializeUpdateAction
	*
	* @return void
	*/
	public function initializeUpdateAction() {
		if (isset($this->arguments['sermon'])) {
			$this->arguments['sermon']->getPropertyMappingConfiguration()->forProperty('date')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		}
	}
	
	/**
	 * action update
	 *
	 * @return void
	 */
	public function updateAction(Sermons $sermon) {

		// upload and assign new file
		$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
		$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
		if (count($_FILES['tx_fkusermon_sermons']['error'])) {
			foreach ($_FILES['tx_fkusermon_sermons']['error'] as $fileId => $error) {
				if ($error == UPLOAD_ERR_OK) {
					
					// upload file
					$fileStoreName = 'PD'.$sermon->getDate()->format('ymd').'_'.substr(uniqid(''),5,6).'.'.pathinfo($_FILES['tx_fkusermon_sermons']['name'][$fileId], PATHINFO_EXTENSION);
					$fileTempName = $_FILES['tx_fkusermon_sermons']['tmp_name'][$fileId];
					$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
					$fileRef = new \FKU\FkuSermon\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$sermon->addRelatedFile($fileRef);
				}
			}
		}

		// unlink (not delete) relation to files
		if ($this->request->hasArgument('delDocument')) {
			$delFiles = $this->request->getArgument('delDocument');
			if (sizeof($delFiles) > 0) {
				foreach ($delFiles as $fileId => $delete) {
					if ($delete) {
						// delete relation
						$fileRef = $this->fileReferenceRepository->findByUid($fileId);
						$sermon->removeRelatedFile($fileRef);
						$this->fileReferenceRepository->remove($fileRef);
					}
				}
			}
		}

		// write to database
		if ($sermon->getTitle() == '') {
			$sermon->setTitle('(kein Titel)');
		}

		$this->sermonsRepository->update($sermon);
		$this->addFlashMessage('Die Predigt-Angaben wurden gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		
		// Generate notifications as per user-specific rules
		if ($sermon->getNotpublic() == false and $sermon->_getCleanProperty('notpublic') == true) {
			$this->generateNotifications($sermon);
		}
		
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @return void
	 */
	public function deleteAction(Sermons $sermon) {
		$this->sermonsRepository->remove($sermon);
		$this->addFlashMessage('Die Predigt wurde gelöscht.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		$this->redirect('list');
	}

	/**
	* generateNotifications
	*
	* @return void
	*/
    protected function generateNotifications(Sermons $sermon) {	
		$notifications = $this->notificationRepository->findAllOfExtension('fku_sermon');
		if ($notifications->count() > 0) {
			$notifText[0] = sprintf($notifications->getFirst()->getRule()->getMessage(), $sermon->getDate()->format('d.m.y'));
			$this->notificationCommand->storeNotifications($notifications, $notifText);
		}
    }
}