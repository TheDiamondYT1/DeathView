<?php

namespace TheDiamondYT\DeathView;

use pocketmine\scheduler\PluginTask;
use pocketmine\Player;

class SpectateTask extends PluginTask {

    private $plugin;
    private $player;
    
    public function __construct(Main $plugin, Player $player) {
        parent::__construct($plugin);  
        $this->plugin = $plugin;
        $this->player = $player;
    }
    
    public function onRun($currentTick) {
        $cfg = $this->plugin->cfg;
        $this->player->setGamemode(Player::SURVIVAL);
        if($cfg["teleport-to-spawn"] === true) {
            $this->player->teleport($this->player->getServer()->getDefaultLevel()->getSafeSpawn()); 
        }
    }
}
  
