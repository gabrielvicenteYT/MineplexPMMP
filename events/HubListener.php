<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\items\Items;
use pocketmine\event\block\BlockPlaceEvent;
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
        $event->setJoinMessage(TextFormat::colorize("&l&6Players&8 >&a " . $player->getName() . " joined the server"));
        Items::giveHubItems($player);
        $player->sendTitle(
            TextFormat::colorize("&8&l&m[ &r &9&lMineplex&r &f&lGames&r &8&l&m ]&b&l&m"),
            TextFormat::colorize("&l&aAlpha Launch &6(ﾉ◕ヮ◕)ﾉ*:･ﾟ✧"),
            20,
            60,
            20);
    }
    
    /**
     * onQuit
     *
     * @param  mixed $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event) : void{
        $player = $event->getPlayer();
        $event->setQuitMessage(TextFormat::colorize("&l&6Players&8 >&a " . $player->getName() . " left the server"));
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
    
    /**
     * onPlace
     *
     * @param  mixed $event
     * @return void
     */
    public function onPlace(BlockPlaceEvent $event) : void{
        /* Do i need this ? since the server only runs this plugin */
        if($event->isCancelled()){
            return;
        }
        Items::formHandle($event);
    }
    public function onInteract(PlayerInteractEvent $event) : void{
        /* Do i need this ? since the server only runs this plugin */
        if($event->isCancelled()){
            return;
        }
        Items::formHandle($event);
    }
}