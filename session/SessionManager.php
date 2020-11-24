<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\events\session\SessionLoadEvent;
use DinoVNOwO\Base\events\SessionListener;
use DinoVNOwO\Base\Initial;
use pocketmine\Player;
use spl_object_hash;

class SessionManager{

    private $session = [];
    
    public function init(){
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        Initial::implementEvent(new SessionListener());
    }
    
    public function load(Session $session, bool $call = true) : void{
        if($call){
            $event = new SessionLoadEvent($session);
            $event->call();
        }
        $this->session[spl_object_hash($session->getPlayer())] = $event->getSession();
    }

    public function destroy(Session $session, bool $call = true) : void{
        if($call){
            $event = new SessionDestroyEvent($session);
            $event->call();
        }
        unset($this->session[spl_object_hash($session->getPlayer())]);
    }
    
    public function getSessions() : array{
        return $this->session;
    }
    
    public function getSession(Player $player) : Session{
        return $this->session[spl_object_hash($player)];
    }
    
    public function shutdown() : void{
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        foreach($this->session as $session){
            $this->destroy($session);
        }
    }
}