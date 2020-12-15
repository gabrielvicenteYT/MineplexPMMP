<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session\events;

use DinoVNOwO\Base\session\Session;

class SessionLoadEvent extends SessionEvent{
    
    /**
     * __construct
     *
     * @param  mixed $session
     * @return void
     */
    public function __construct(Session $session){
        parent::__construct($session);
    }
}