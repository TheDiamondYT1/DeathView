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
	        if($ent->getGamemode() === Player::CREATIVE) return;
	        $ev->setCancelled(true);
	        $ent->setGamemode(Player::SPECTATOR);
	        $this->getServer()->getScheduler()->scheduleDelayedTask(new SpectateTask($this, $ent), $this->cfg["time"] * 20);
	        if($this->cfg["fire-death-event"] === true) {
	            //$this->getServer()->getPluginManager()->callEvent($this, $ent->getDrops());
	        }
	        if($this->cfg["death-message"]["display"] === true) {
	            $ent->sendMessage($this->replace($ev, $this->cfg["death-message"]["died"]["player"]));
	            $this->getServer()->broadcastMessage($this->replace($ev, $this->cfg["death-message"]["died"]["all"]));
	        }
		}
	}
	
	/**
	 * @param Event  $ev
	 * @param string $text
	 *
	 * @return string
	 */
	private function replace($ev, string $text): string {
	    $text = str_replace("{victim}", $ev->getEntity()->getName(), $text);
	    $text = str_replace("{world}", $ev->getEntity()->getLevel()->getName(), $text);
	    return $text;
	}
}
