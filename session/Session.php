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

    private $gems = 0;
    private $coins = 0;
    
    /**
     * __construct
     *
     * @param  mixed $player
     * @param  mixed $gems
     * @param  mixed $coins
     * @return void
     */
    public function __construct(Player $player, int $gems = 0, int $coins = 0){
        $this->player = $player;
        $this->gems = $gems;
        $this->coins = $coins;
    }
    
    /**
     * getPlayer
     *
     * @return Player
     */
    public function getPlayer() : Player{
        return $this->player;
    }
    
    /**
     * getGems
     *
     * @return int
     */
    public function getGems() : int{
        return $this->gems;
    }
    
    /**
     * getCoins
     *
     * @return int
     */
    public function getCoins() : int{
        return $this->coins;
    }
    
    /**
     * setGems
     *
     * @param  mixed $gems
     * @return void
     */
    public function setGems(int $gems) : void{
        $this->gems = $gems;
    }
    
    /**
     * setCoins
     *
     * @param  mixed $coins
     * @return void
     */
    public function setCoins(int $coins) : void{
        $this->coins = $coins;
    }
}