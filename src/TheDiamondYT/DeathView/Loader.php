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

class Loader extends PluginBase implements Listener {
	/** @var array */
	private $config;
	
	public function onEnable() {
		$this->saveDefaultConfig();
		$this->config = $this->getConfig()->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		// Check for clash	
		if($this->config["teleport"] && $this->config["teleport-to-spawn"]) {
			throw new \Exception("Teleporting to spawn enable in config, but teleporting to specific coordinates is also enabled.");
		}
	}
	
	/**
	 * @param EntityDamageEvent $ev
	 *
	 * @priorty         HIGH
	 * @ignoreCancelled false
	 */
	public function onEntityDamage(EntityDamageEvent $ev) {
		if($ev->isCancelled()) {
			return;
		}    
		$entity = $ev->getEntity();
	    
		if($entity instanceof Player and $entity->getHealth() - $ev->getDamage() <= 0) {
			if($entity->getGamemode() === Player::CREATIVE){
				return;
			}
			$ev->setCancelled(true);
			$entity->setGamemode(Player::SPECTATOR);
			$this->getServer()->getScheduler()->scheduleDelayedTask(new SpectateTask($this, $entity), $this->config["time"] * 20);  
	           
			if($this->config["fire-death-event"]) {
				//$this->getServer()->getPluginManager()->callEvent($this, $entity->getDrops());
			}
	        
			if($this->config["death-message"]["display"]) {
				$entity->sendMessage($this->replace($ev, $this->config["death-message"]["died"]["player"]));
				$this->getServer()->broadcastMessage($this->replace($ev, $this->config["death-message"]["died"]["all"]));
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
