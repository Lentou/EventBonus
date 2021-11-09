<?php

declare(strict_types=1);

namespace lentou\EventBonus\command;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

use lentou\EventBonus\Main;

class BonusCommand extends Command {

	public function __construct() {
		parent::__construct("bonus");
		$this->setDescription("the main command of bonus event #L2");
		$this->setUsage(TextFormat::YELLOW . "Usage: /bonus help");
		$this->setAliases(["bo", "b"]);
		$this->setPermission("lentou.eventbonus.command");
		$this->setPermissionMessage(TextFormat::RED . "You don't have permission to use EventBonus Command!");
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
		if (!$this->testPermission($sender)) {
			return false;
		}
		
		if (empty($args[0])) {
			$sender->sendMessage($this->getUsage());
			return false;
		}
		
		switch($args[0]) {
			case "make":
				if (empty($args[1])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus make <bonus_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus make uhcEvent");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				
				if (array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus is already exists, give us a new unique name!");
					return false;
				}
				
				if (strlen($bonusName) < 3) {
					$sender->sendMessage(TextFormat::RED . "The length of bonus-name should greater than 3, longer the word!");
					return false;
				}
				
				Main::getInstance()->makeBonus($bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully created a Bonus called " . $bonusName . ", do /bonus addplayer " . $bonusName . " <player> to add an player and received a reward when they joined or online!");
				$sender->sendMessage(TextFormat::GREEN . "and do /bonus addcmd " . $bonusName . " <cmd_name> to add a command in event bonus reward!");
			break;
			case "del":
				if (empty($args[1])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus del <bonus_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus del uhcEvent");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				Main::getInstance()->delBonus($bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully deleted the Bonus called " . $bonusName . ", no more rewards :(");
			break;
			case "addplayer":
				if (empty($args[1]) or empty($args[2])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus addplayer <bonus_name> <player_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus addplayer uhcEvent Hytlenz");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				$playerName = strtolower($args[2]);
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				if (in_array($playerName, Main::getInstance()->getConfig()->getNested("bonus." . $bonusName . ".players"))) {
					$sender->sendMessage(TextFormat::RED . "Player " . $playName . " is already registered in " . $bonusName . " bonus list");
					return false;
				}
				
				Main::getInstance()->addPlayerBonus($playerName, $bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully added " . $playerName . " in " . $bonusName . " bonus list!");
			break;
			case "delplayer":
				if (empty($args[1]) or empty($args[2])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus delplayer <bonus_name> <player_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus delplayer uhcEvent Hytlenz");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				$playerName = strtolower($args[2]);
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				if (in_array($playerName, Main::getInstance()->getConfig()->getNested("bonus." . $bonusName . ".players"))) {
					$sender->sendMessage(TextFormat::RED . "Player " . $playName . " doesn't exists in " . $bonusName . " bonus list");
					return false;
				}
				
				Main::getInstance()->delPlayerBonus($playerName, $bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully removed " . $playerName . " in " . $bonusName . " bonus list!");
			break;
			case "addcmd":
				if (empty($args[1]) or empty($args[2])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus addcmd <bonus_name> <cmd_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus addcmd uhcEvent give {player} diamond 1");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				$cmdName = strtolower($args[2]);
				
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				array_shift($args);
				array_shift($args);
				$cmdName = trim(implode(" ", $args));
				
				if (in_array($cmdName, Main::getInstance()->getConfig()->getNested("bonus." . $bonusName . ".cmds"))) {
					$sender->sendMessage(TextFormat::RED . "Command /" . $cmdName . " is already registered in " . $bonusName . " bonus list");
					return false;
				}
				
				
				Main::getInstance()->addCommandBonus($cmdName, $bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully added /" . $cmdName . " in " . $bonusName . " bonus list!");
			break;
			case "delcmd":
				if (empty($args[1]) or empty($args[2])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus delcmd <bonus_name> <cmd_name>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus delcmd uhcEvent give {player} diamond 1");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				$cmdName = strtolower($args[2]);
				
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				array_shift($args);
				array_shift($args);
				$cmdName = trim(implode(" ", $args));
				
				if (!in_array($cmdName, Main::getInstance()->getConfig()->getNested("bonus." . $bonusName . ".cmds"))) {
					$sender->sendMessage(TextFormat::RED . "Command /" . $cmdName . " doesn't exists in " . $bonusName . " bonus list");
					return false;
				}
				
				
				Main::getInstance()->delCommandBonus($cmdName, $bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully deleted /" . $cmdName . " in " . $bonusName . " bonus list!");
			break;
			case "setmsg":
				if (empty($args[1]) or empty($args[2])) {
					$sender->sendMessage(TextFormat::YELLOW . "Usage: /bonus setmsg <bonus_name> <msg>");
					$sender->sendMessage(TextFormat::YELLOW . "Example: /bonus setmsg uhcEvent &eYou receive the reward &afrom UHC EVENT, Enjoy :)");
					return false;
				}
				
				$bonusName = strtolower($args[1]);
				$setMsg = $args[2];
				
				if (!array_key_exists($bonusName, Main::getInstance()->getConfig()->getNested("bonus"))) {
					$sender->sendMessage(TextFormat::RED . "This Bonus doesn't exists!");
					return false;
				}
				
				array_shift($args);
				array_shift($args);
				$setMsg = trim(implode(" ", $args));
				Main::getInstance()->setBonusMsg($setMsg, $bonusName);
				$sender->sendMessage(TextFormat::GREEN . "Successfully set the message of " . $bonusName);
			break;
			case "list":
				$sender->sendMessage(TextFormat::YELLOW . "List of EventBonus:");
				foreach (Main::getInstance()->getConfig()->getNested("bonus") as $bonus => $value) {
					$sender->sendMessage(TextFormat::YELLOW . "- Bonus: " . $bonus);
					$sender->sendMessage(TextFormat::GREEN . "-- Players: " . implode(", ", $value["players"]));
					$sender->sendMessage(TextFormat::GREEN . "-- Commands: ");
					$sender->sendMessage(TextFormat::GREEN . "- " . implode("\n", $value["cmds"]));
					$sender->sendMessage(TextFormat::GREEN . "-- Message: " . $value["message"]);
				}
			break;
			default:
				$sender->sendMessage(TextFormat::YELLOW . "EventBonus Commands:");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus help : to see all list of commands");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus make <bonus_name> : to create a bonus for players who won in mini-events");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus del <bonus_name> : to delete the bonus");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus addplayer <bonus_name> <player_name> : to register a player in bonus reward event");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus delplayer <bonus_name> <player_name> : to unregister a player in bonus reward event");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus addcmd <bonus_name> <cmd_name> : to register a command that executes when giving a rewards to players");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus delcmd <bonus_name> <cmd_name> : to unregister a command in bonus reward event");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus setmsg <bonus_name> <msg> : to set an message when the player received the reward bonus");
				$sender->sendMessage(TextFormat::YELLOW . "- /bonus list : to see all event bonus");
				
		}
		return true;
	}	
}
