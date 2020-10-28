<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\group\Group;
use DinoVNOwO\Base\Initial;
use pocketmine\permission\PermissionAttachment;
use pocketmine\Player;

class Session{

    protected $player;

    private $groupid = -1;

    private $gems = 0;
    private $coins = 0;

    private $attachment;
    
    /**
     * __construct
     *
     * @param  Player $player
     * @param  int $gems
     * @param  int $gems
     * @param  int $coins
     * @param  int $groupid
     * @param  PermissionAttachment $attachment
     * @return void
     */
    public function __construct(Player $player, int $gems = 0, int $coins = 0, int $groupid = -1, PermissionAttachment $attachment = null){
        $this->player = $player;
        $this->gems = $gems;
        $this->coins = $coins;
        $this->groupid = $groupid;
        $this->attachment = $attachment;
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
     * getGroupId
     *
     * @return int
     */
    public function getGroupId() : int{
        return $this->groupid;
    }
    
    /**
     * getAttachment
     *
     * @return int
     */
    public function getAttachment() : PermissionAttachment{
        return $this->attachment;
    }
    
    /**
     * getGroup
     *
     * @return int
     */
    public function getGroup() : Group{
        var_dump(Initial::getGroupManager()->getGroup($this->groupid));
        return Initial::getGroupManager()->getGroup($this->groupid);
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
    
    /**
     * setGroupId
     *
     * @param  mixed $groupid
     * @return void
     */
    public function setGroupId(int $groupid) : void{
        $this->groupid = $groupid;
    }
}