<?php

declare(strict_types=1);

namespace lentou\EventBonus;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\ClosureTask;

use lentou\EventBonus\event\BonusEvent;
use lentou\EventBonus\command\BonusCommand;

class Main extends PluginBase {

	use SingletonTrait;
	
	protected function onEnable() : void {
		self::setInstance($this);
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents(new BonusEvent(), $this);
		$this->getServer()->getCommandMap()->register("lentou:bonus", new BonusCommand());
		
		$this->getScheduler()->scheduleDelayedRepeatingTask(new ClosureTask(function(int $currentTick) : void {
			foreach($this->getServer()->getOnlinePlayers() as $player){
				foreach ($this->getConfig()->getNested("bonus") as $bonus => $value) {
					if (in_array(strtolower($player->getName()), $value["players"])) {
						$this->giveEventBonus($player, $bonus);
					}
				}
			}
		}), 10, 10);
	}
	
	public function makeBonus(string $bonusName) : void {
		$this->getConfig()->setNested("bonus." . $bonusName . ".players", []);
		$this->getConfig()->setNested("bonus." . $bonusName . ".cmds", []);
		$this->getConfig()->setNested("bonus." . $bonusName . ".message", "You just received " . $bonusName . " reward");
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function delBonus(string $bonusName) : void {
		$bonusCfg = $this->getConfig()->getAll();
		unset($bonusCfg["bonus"][$bonusName]);
		$this->getConfig()->setAll($bonusCfg);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function addPlayerBonus(string $playerName, string $bonusName) : void {
		$addedPlayer = $this->getConfig()->getNested("bonus." . $bonusName . ".players");
		$addedPlayer[] = $playerName;
		$this->getConfig()->setNested("bonus." . $bonusName . ".players", $addedPlayer);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function delPlayerBonus(string $playerName, string $bonusName) : void {
		$listPlayers = $this->getConfig()->getNested("bonus." . $bonusName . ".players");
		$members = [];
		foreach($listPlayers as $player) {
			if ($player !== $playerName) {
				$members[] = $player;
			}
		}
		$this->getConfig()->setNested("bonus." . $bonusName . ".players", $members);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function addCommandBonus(string $cmdName, string $bonusName) : void {
		$addedCommand = $this->getConfig()->getNested("bonus." . $bonusName . ".cmds");
		$addedCommand[] = $cmdName;
		$this->getConfig()->setNested("bonus." . $bonusName . ".cmds", $addedCommand);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function delCommandBonus(string $cmdName, string $bonusName) : void {
		$listCommands = $this->getConfig()->getNested("bonus." . $bonusName . ".cmds");
		$command = [];
		foreach($listCommands as $cmd) {
			if ($cmd !== $cmdName) {
				$command[] = $cmd;
			}
		}
		$this->getConfig()->setNested("bonus." . $bonusName . ".cmds", $command);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function setBonusMsg(string $setMsg, string $bonusName) : void {
		$this->getConfig()->setNested("bonus." . $bonusName . ".message", $setMsg);
		$this->getConfig()->save();
		$this->getConfig()->reload();
	}
	
	public function giveEventBonus(Player $player, string $bonusName) : void {
		foreach ($this->getConfig()->getNested("bonus." . $bonusName . ".cmds") as $command) {
			$command = str_replace('{player}', '"' . $player->getName() . '"', $command);
			$this->getServer()->dispatchCommand(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), $command);
		}
		$player->sendMessage(TextFormat::colorize($this->getConfig()->getNested("bonus." . $bonusName . ".message")));
		$this->delPlayerBonus(strtolower($player->getName()), $bonusName);
	}
}
