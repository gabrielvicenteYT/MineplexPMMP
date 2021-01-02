<?php

declare(strict_types=1);

use DinoVNOwO\Base\session\events\SessionEvent;
use DinoVNOwO\Base\session\Session;

class PlayerQuitGameEvent extends SessionEvent
{

    /**
     * @var BaseGamemode
     */
    private $gamemode;

    public function __construct(Session $session, BaseGamemode $gamemode){
        $this->gamemode = $gamemode;
        parent::__construct($session);
    }
    
    public function getGamemode() : BaseGamemode{
        return $this->gamemode;
    }

}