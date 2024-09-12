<?php

namespace BNTFeujjj\fCustomKnockBack;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase implements Listener {

    use SingletonTrait;
    public function onLoad(): void
    {
        self::setInstance($this);
    }
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("customknockback", new CustomKnockBackCommand());
    }

    public function onDamage(EntityDamageByEntityEvent $event): void {
        $event->setAttackCooldown($this->getConfig()->get("attackcooldown"));
        $event->setKnockBack($this->getConfig()->get("knockback"));
    }
}