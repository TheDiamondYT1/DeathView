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
        $cfg = $this->owner->cfg;
        $this->player->setGamemode(Player::SURVIVAL);
        if($cfg["teleport-to-spawn"] === true) {
            $this->player->teleport($this->owner->getServer()->getDefaultLevel()->getSafeSpawn());
        }
    }
}


