<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\events\session\SessionLoadEvent;
use DinoVNOwO\Base\Initial;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class HubEvent implements Listener{

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        Initial::getSessionManager()->loadSession($player);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->removeAllEffects();
        $player->teleport(Initial::getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
        $event->setJoinMessage(TextFormat::colorize("&l&6Players&8 >&a " . $player->getName() . " joined the server"));
    }

    public function onQuit(PlayerQuitEvent $event) : void{
        $player = $event->getPlayer();
        Initial::getSessionManager()->destroySession($player);
        $event->setQuitMessage(TextFormat::colorize("&l&6Players&8 >&a " . $player->getName() . " left the server"));
    }

    public function onDamage(EntityDamageEvent $event) : void{
        $event->setCancelled();
        if($event->getCause() === EntityDamageEvent::CAUSE_VOID){
            if($event->getEntity() instanceof Player){
                $event->getEntity()->teleport(Initial::getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
            }else{
                /* Hm :thonk: */
                $event->getEntity()->kill();
            }
        }
    }
}
