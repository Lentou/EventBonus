<?php

declare(strict_types=1);

namespace lentou\EventBonus\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use lentou\EventBonus\Main;

class BonusEvent implements Listener {

	public function onJoin(PlayerJoinEvent $event) : void {
		$player = $event->getPlayer();
		foreach (Main::getInstance()->getConfig()->getNested("bonus") as $bonus => $value) {
			if (in_array(strtolower($player->getName()), $value["players"])) {
				Main::getInstance()->giveEventBonus($player, $bonus);
			}
		}
	}
	
}
