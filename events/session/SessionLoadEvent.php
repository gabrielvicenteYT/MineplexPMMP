<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events\session;

use DinoVNOwO\Base\events\SessionEvent;
use DinoVNOwO\Base\session\Session;

class SessionLoadEvent extends SessionEvent{

    public function __construct(Session $session){
        parent::__construct($session);
    }
}