<?php

declare(strict_types=1);

namespace lentou\EventBonus\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use lentou\EventBonus\Main;

class BonusEvent implements Listener {

	private Main $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onJoin(PlayerJoinEvent $event) : void {
		$player = $event->getPlayer();
		foreach ($this->getMain()->getConfig()->getNested("bonus") as $bonus => $value) {
			if (in_array(strtolower($player->getName()), $value["players"])) {
				$this->getMain()->giveEventBonus($player, $bonus);
			}
		}
	}
	
	public function getMain() : Main {
		return $this->plugin;
	}
	
}
