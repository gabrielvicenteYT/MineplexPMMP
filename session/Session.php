<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\events\group\GroupUpdateEvent;
use DinoVNOwO\Base\events\session\SessionDestroyEvent;
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
    
    public function __construct(Player $player, int $gems = 0, int $coins = 0, int $groupid = -1, PermissionAttachment $attachment = null){
        $this->player = $player;
        $this->gems = $gems;
        $this->coins = $coins;
        $this->groupid = $groupid;
        $this->attachment = $attachment;
        $this->getAttachment()->clearPermissions();
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
    
    public function getGroupId() : int{
        return $this->groupid;
    }
    
    public function getAttachment() : PermissionAttachment{
        return $this->attachment;
    }
    
    public function getGroup() : Group{
        return Initial::getGroupManager()->getGroup($this->groupid);
    }
    
    public function setGems(int $gems) : void{
        $this->gems = $gems;
    }
    
    public function setCoins(int $coins) : void{
        $this->coins = $coins;
    }
    
    public function updateGroup(int $groupid, bool $call = true) : void{
        if($call){
            $event = new GroupUpdateEvent($this, $groupid);
            $event->call();
        }
        $this->groupid = $groupid;
        $this->recalculateGroupPermission();
    }

    public function recalculateGroupPermission() : void{
        $permissions = $this->getGroup()->getPermissions();
        foreach($permissions as $permission){
            $permission = Initial::getPlugin()->getServer()->getPluginManager()->getPermission($permission);
            $this->getAttachment()->clearPermissions();
            $this->getAttachment()->setPermission($permission, true);
        }
    }
}