<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\Initial;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class ServerUpdateListener implements Listener{
    
    /**
     * onJoin
     *
     * @param  mixed $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent $event) : void{
        Initial::getServerManager()->playerCountUpdate(count(Initial::getPlugin()->getServer()->getOnlinePlayers()));
    }
    
    /**
     * onQuit
     *
     * @param  mixed $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event) : void{
        Initial::getServerManager()->playerCountUpdate(count(Initial::getPlugin()->getServer()->getOnlinePlayers()));
    }
}