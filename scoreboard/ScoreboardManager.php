<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\scoreboard;

use DinoVNOwO\Base\hub\scoreboard\HubScoreboard;

class ScoreboardManager{

    /**
     * @var array
     */
    private $scoreboard = [];
    /**
     * @var string
     */
    private $default;

    public function init()
    {
        $hub = new HubScoreboard();
        $this->scoreboard[$hub->getId()] = $hub;
    }

    /**
     * @param string $id
     * @return Scoreboard|null
     */
    public function getScoreboard(string $id) : ?Scoreboard{
        return $this->scoreboard[$id];
    }

    /**
     * @param string $id
     */
    public function setDefaultScoreboard(string $id) : void{
        $this->default = $id;
    }

    /**
     * @return Scoreboard
     */
    public function getDefaultScoreboard(): Scoreboard
    {
        return $this->getScoreboard($this->default);
    }
}