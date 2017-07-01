<?php

namespace TheDiamondYT\DeathView;

use pocketmine\scheduler\PluginTask;
use pocketmine\Player;

class SpectateTask extends PluginTask {
	/** @var Player */
	private $player;

	public function __construct(Main $plugin, Player $player) {
		parent::__construct($plugin);
		$this->player = $player;
	}

	public function onRun($currentTick) {
		$config = $this->getOwner()->getConfig();
        
		$this->player->setGamemode(Player::SURVIVAL);
        
		if($config["teleport-to-spawn"]) {
			$this->player->teleport($this->owner->getServer()->getDefaultLevel()->getSafeSpawn());
		} 
		if($config["teleport"]) {
			$this->player->teleport($config["teleport-to"]["x"], $config["teleport-to"]["y"], $config["teleport-to"]["z"]);
		}
	}
}

