<?php

declare(strict_types=1);

use pocketmine\event\Cancellable;
use pocketmine\event\Event;

class GameEvent extends Event implements Cancellable
{

    /**
     * @var BaseGamemode
     */
    private $gamemode;

    public function __construct(BaseGamemode $gamemode)
    {
        $this->gamemode = $gamemode;
    }

    /**
     * @return BaseGamemode
     */
    public function getGamemode(): BaseGamemode
    {
        return $this->gamemode;
    }
}