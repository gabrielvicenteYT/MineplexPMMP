<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\events\session\SessionLoadEvent;
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

    public function loadSession(Player $player, bool $called = true) : void{
        if($called){
            $event = new SessionLoadEvent(new Session($player, -1, -1));
            $event->call();
            /*
            if($event->isCancelled()){
                return;
            }
            */
        }
        $this->session[spl_object_hash($player)] = $event->getSession();
        var_dump($this->session);
    }

    public function destroySession(Player $player, bool $called = true) : void{
        if($called){
            $event = new SessionDestroyEvent($this->session[spl_object_hash($player)]);
            $event->call();
            /*
            if($event->isCancelled()){
                return;
            }
            */
        }
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