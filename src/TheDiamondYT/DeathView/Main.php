<?php

namespace TheDiamondYT\DeathView;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\utils\TextFormat as TF;

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
	        $this->getServer()->getScheduler()->scheduleDelayedTask(new SpectateTask($this, $ent), $this->cfg["time"] * 20);
	    }
	}
	
	public function onPlayerDeath(PlayerDeathEvent $ev) {
	    $player = $ev->getPlayer();
	    if($this->cfg["death-message"]["display"] === true) {
	        $player->sendMessage($this->replace($player, $this->cfg["death-message"]["died"]["player"]));
	        $ev->setDeathMessage($this->replace($player, $this->cfg["death-message"]["died"]["all"]));
	        return;
		}
		$ev->setDeathMessage(null);
	}
	
	private function replace(Player $player, $text) {
	    $text = str_replace("{victim}", $player->getName(), $text);
	    $text = str_replace("{world}", $player->getLevel()->getName(), $text);
	    $text = str_replace("&", TF::ESCAPE, $text);
	    return $text;
	}
}
