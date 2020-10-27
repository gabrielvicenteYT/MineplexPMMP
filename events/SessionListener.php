<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\events\session\SessionLoadEvent;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener{

    /**
     * Handle session on destroy
     *
     * @param  mixed $event
     * @return void
     * @priority LOWEST
     */
    public function onSessionDestroy(SessionDestroyEvent $event) : void{
        Initial::getDatabaseManager()->getConnection()->executeInsert("players.update.gems", 
        [
            "xuid" => $event->getSession()->getPlayer()->getXuid(),
            "gems" => $event->getSession()->getGems() + 100
        ]);
        Initial::getDatabaseManager()->getConnection()->executeInsert("players.update.coins", 
        [
            "xuid" => $event->getSession()->getPlayer()->getXuid(),
            "coins" => $event->getSession()->getCoins() + 100
        ]);
    }

    
    /**
     * onJoin
     *
     * @param  mixed $event
     * @return void
     * @priority LOWEST
     */
    public function onJoin(PlayerJoinEvent $event) : void{
        Initial::getDatabaseManager()->getConnection()->executeSelect("players.find", 
        [
            "xuid" => $event->getPlayer()->getXuid()
        ],
        function(array $data) use($event){
            if($data === []){
                Initial::getDatabaseManager()->getConnection()->executeInsert("players.insert", 
                [
                    "xuid" => $event->getPlayer()->getXuid(),
                    "gems" => 0,
                    "coins" => 0,
                    "rank" => 0
                ]);
                $data[0] = ["coins" => 0, "rank" => 0, "gems" => 0];
            }
            $session = new Session($event->getPlayer(), $data[0]["gems"], $data[0]["coins"]);
            Initial::getSessionManager()->loadSession($session);
        });
    }
    
    /**
     * onQuit
     *
     * @param  mixed $event
     * @return void
     * @priority LOWEST
     */
    public function onQuit(PlayerQuitEvent $event) : void{
        Initial::getSessionManager()->destroySession(Initial::getSessionManager()->getSession($event->getPlayer()));
    }
}