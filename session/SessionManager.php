<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\Initial;
use pocketmine\Player;
use spl_object_hash;

class SessionManager{

    private $session = [];

    public function init(){
        foreach(Initial::getPlugin()->getServer()->getOnlinePlayers() as $player){
            $this->loadSession($player);
        }
    }

    public function loadSession(Player $player) : void{
        $this->session[spl_object_hash($player)] = new Session($player, -1, -1);
        /* TODO Database implement */
        var_dump($this->session);
    }

    public function destroySession(Player $player) : void{
        /* Call event */
        unset($this->session[spl_object_hash($player)]);
    }

    public function getSession(Player $player) : Session{
        return $this->session[$player];
    }

    public function getSessions() : array{
        return $this->session;
    }

    public function shutdown() : void{
        /* Hate reload shit */
        $this->session = [];
    }
}