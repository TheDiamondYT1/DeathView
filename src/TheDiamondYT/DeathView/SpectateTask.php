<?php

namespace TheDiamondYT\DeathView;

use pocketmine\scheduler\PluginTask;
use pocketmine\Player;

class SpectateTask extends PluginTask {

    private $player;

    public function __construct(Main $plugin, Player $player) {
        parent::__construct($plugin);
        $this->player = $player;
    }

    public function onRun($currentTick) {
        $cfg = $this->getOwner()->cfg;
        
        $this->player->setGamemode(Player::SURVIVAL);
        
        if($cfg["teleport-to-spawn"]) {
            $this->player->teleport($this->owner->getServer()->getDefaultLevel()->getSafeSpawn());
        } 
        if($cfg["teleport"]) {
            $this->player->teleport($cfg["teleport-to"]["x"], $cfg["teleport-to"]["y"], $cfg["teleport-to"]["z"]);
        }
    }
}

