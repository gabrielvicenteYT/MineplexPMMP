<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use pocketmine\Player;

class Session{

    /* 
    Storing Player Data

    TODO: Multi Server Support
    */

    protected $player;

    private $rank;

    private $gems = -1;
    private $coins = -1;

    public function __construct(Player $player, int $gems = -1, int $coins = -1){
        $this->player = $player;
        $this->gems = $gems;
        $this->coins = $coins;
    }

    public function getPlayer() : Player{
        return $this->player;
    }

    public function getGems() : int{
        return $this->gems;
    }

    public function getCoins() : int{
        return $this->coins;
    }

    public function setGems(int $gems) : void{
        $this->gems = $gems;
    }

    public function setCoins(int $coins) : void{
        $this->coins = $coins;
    }
}