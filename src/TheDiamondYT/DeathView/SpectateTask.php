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
        $player->setGamemode(Player::SURVIVAL);
        if($cfg["teleport-to-spawn"] === true) {
            $player->teleport($this->owner->getServer()->getDefaultLevel()->getSafeSpawn());
        }
    }
}


