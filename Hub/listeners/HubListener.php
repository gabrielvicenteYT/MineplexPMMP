<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub\listeners;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\utils\FormatContainer;
use DinoVNOwO\Hub\items\Items;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class HubListener implements Listener{
    
    /**
     * onJoin
     *
     * @param  mixed $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->removeAllEffects();
        $player->teleport(Initial::getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
        $event->setJoinMessage(FormatContainer::format(FormatContainer::PLAYER_JOIN, ["{name}"], [$player->getName()]));
        Items::giveHubItems($player);
        $player->sendTitle(TextFormat::colorize("&8&l&m[ &r &9&lEntroMC&r &f&lGames&r &8&l&m ]&b&l&m"),  TextFormat::colorize("&l&aAlpha Launch &6(ﾉ◕ヮ◕)ﾉ*:･ﾟ✧"), 20, 60, 20);
    }
    
    /**
     * onQuit
     *
     * @param  mixed $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event) : void{
        $player = $event->getPlayer();
        $event->setQuitMessage(FormatContainer::format(FormatContainer::PLAYER_QUIT, ["{name}"], [$player->getName()]));
    }
    
    /**
     * onDamage
     *
     * @param  mixed $event
     * @return void
     */
    public function onDamage(EntityDamageEvent $event) : void{
        $event->setCancelled();
        if($event->getCause() === EntityDamageEvent::CAUSE_VOID){
            if($event->getEntity() instanceof Player){
                $event->getEntity()->teleport(Initial::getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
            }else{
                $event->getEntity()->kill();
            }
        }
    }

    public function onInteract(PlayerInteractEvent $event) : void{
        if($event->isCancelled()){
            return;
        }
        if($event->getItem()->getNamedTag()->hasTag("Form")){
            $event->setCancelled();
            $session = Initial::getSessionManager()->getSession($event->getPlayer());
            Initial::getFormsManager()->getForm($event->getItem()->getNamedTag()->getString("Form"))->send($session);
        }
    }
}