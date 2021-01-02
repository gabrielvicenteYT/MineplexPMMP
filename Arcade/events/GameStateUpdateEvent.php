<?php


class GameStateUpdateEvent extends GameEvent
{

    /**
     * @var int
     */
    private $state;

    public function __construct(BaseGamemode $gamemode, int $state)
    {
        $this->state = $state;
        parent::__construct($gamemode);
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }
}