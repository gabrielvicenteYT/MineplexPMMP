<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use DinoVNOwO\Base\session\events\SessionDestroyEvent;
use DinoVNOwO\Base\session\events\SessionLoadEvent;
use pocketmine\Player;
use function spl_object_hash;

class SessionManager extends Manager {

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
            $this->session[spl_object_hash($session->getPlayer())] = $event->getSession();
        }else{
            $this->session[spl_object_hash($session->getPlayer())] = $session;
        }
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