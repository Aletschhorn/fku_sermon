<?php
namespace FKU\FkuSermon\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use FKU\FkuPeople\Domain\Repository\NotificationruleRepository;

class ext_update {
	
	/**
	 * @var string Extension name
     */
	protected $extensionName = 'fku_sermon';

	/**
	 * @var array Notification rules
     */
	protected $notificationRules = array (
		array (1, 'eine neue Predigt hochgeladen wurde', 'Die Predigt vom %1$s wurde auf die Website hochgeladen.', 1, 1, 1),
	);

    
	/**
	 * Main function, returning the HTML content
	 *
	 * @return string HTML
     */
	public function main() {
		$new = 0;
		$update = 0;

		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$notificationruleRepository = $objectManager->get(NotificationruleRepository::class);

		foreach ($this->notificationRules as $rule) {
			$notification = $notificationruleRepository->findSingle($this->extensionName,$rule[0])->getFirst();
			if ($notification) {
				$notification->setTitle($rule[1]);
				$notification->setMessage($rule[2]);
				$notification->setTimingNow($rule[3]);
				$notification->setTimingDay($rule[4]);
				$notification->setTimingWeek($rule[5]);
				$notificationruleRepository->update($notification);
				$update++;
			} else {
				$notification = new \FKU\FkuPeople\Domain\Model\Notificationrule;
				$notification->setExtension($this->extensionName);
				$notification->setNid($rule[0]);
				$notification->setTitle($rule[1]);
				$notification->setMessage($rule[2]);
				$notification->setTimingNow($rule[3]);
				$notification->setTimingDay($rule[4]);
				$notification->setTimingWeek($rule[5]);
				$notificationruleRepository->add($notification);
				$new++;
			}
		}
		$content = 'Added '.$new.' and updated '.$update.' notification rules in database';
		return $content;		
	}

	/**
	 * Access function, flag to allow or disallow execution
	 *
	 * @return boolean
     */
	public function access() {
		return true;
	}	
}
?>