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
    
    /**
     * Init session manager
     *
     * @return void
     */
    public function init(){
        Initial::implementEvent(new SessionListener());
        foreach(Initial::getPlugin()->getServer()->getOnlinePlayers() as $player){
            $this->loadSession(new Session($player));
        }
    }
        
    /**
     * loadSession
     *
     * @param  mixed $session
     * @param  mixed $called
     * @return void
     */
    public function loadSession(Session $session, bool $called = true) : void{
        if($called){
            $event = new SessionLoadEvent($session);
            $event->call();
        }
        $this->session[spl_object_hash($session->getPlayer())] = $event->getSession();
        var_dump($this->session);
    }
        
    /**
     * destroySession
     *
     * @param  mixed $session
     * @param  mixed $called
     * @return void
     */
    public function destroySession(Session $session, bool $called = true) : void{
        if($called){
            $event = new SessionDestroyEvent($session);
            $event->call();
        }
        unset($this->session[spl_object_hash($session->getPlayer())]);
    }
    
    /**
     * getSession
     *
     * @param  mixed $player
     * @return Session
     */
    public function getSession(Player $player) : Session{
        return $this->session[spl_object_hash($player)];
    }
    
    /**
     * getSessions
     *
     * @return array
     */
    public function getSessions() : array{
        return $this->session;
    }
    
    /**
     * shutdown
     *
     * @return void
     */  
    public function shutdown() : void{
        foreach($this->session as $session){
            $this->destroySession($session);
        }
    }
}