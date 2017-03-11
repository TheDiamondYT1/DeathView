<?php

namespace TheDiamondYT\DeathView;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\entity\Effect;

use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Main extends PluginBase implements Listener {

    public $cfg;
	
	public function onEnable() {
	    $this->saveDefaultConfig();
	    $this->cfg = $this->getConfig()->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onEntityDamage(EntityDamageEvent $ev) {
	    $ent = $ev->getEntity();
	    if($ent instanceof Player && $ent->getHealth() - $ev->getDamage() <= 0) {
	        $ev->setCancelled(true);
	        $ent->setGamemode(Player::SPECTATOR);
	        $this->getServer()->getScheduler()->scheduleDelayedTask(new SpectateTask($this, $ent), $this->cfg["ticks"]);
	    }
	}
	
	public function onPlayerDeath(PlayerDeathEvent $ev) {
	    $player = $ev->getPlayer();
	    if($this->cfg["death-message"]["display"] === true) {
	        $ev->setDeathMessage(str_replace("{victim}", $player->getName(), $this->cfg["death-message"]["died"]));
	        return;
		}
		$ev->setDeathMessage(null);
	}
}
