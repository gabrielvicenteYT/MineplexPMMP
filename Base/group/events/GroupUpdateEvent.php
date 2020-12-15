<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\group\events;

use DinoVNOwO\Base\session\events\SessionEvent;
use DinoVNOwO\Base\session\Session;

class GroupUpdateEvent extends SessionEvent{

    protected $session;
    protected $groupid;

    public function __construct(Session $session, int $groupid){
        parent::__construct($session);
        $this->groupid = $groupid;
    }

    public function getGroupId() : int{
        return $this->groupid;
    }
}