<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\events\group\GroupUpdateEvent;
use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\group\Group;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\scoreboard\Scoreboard;
use pocketmine\permission\PermissionAttachment;
use pocketmine\Player;

class Session
{

    protected $player;

    private $groupid = -1;

    private $gems = 0;
    private $coins = 0;

    private $attachment;

    private $scoreboardId;


    public function __construct(Player $player, int $gems = 0, int $coins = 0, int $groupid = -1, PermissionAttachment $attachment = null, string $scoreboardId)
    {
        $this->player = $player;
        $this->gems = $gems;
        $this->coins = $coins;
        $this->groupid = $groupid;
        $this->attachment = $attachment;
        $this->scoreboardId = $scoreboardId;
        $this->getAttachment()->clearPermissions();
        $this->getScoreboard()->sendScore($this);
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getGems(): int
    {
        return $this->gems;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }

    public function getGroupId(): int
    {
        return $this->groupid;
    }

    public function getAttachment(): PermissionAttachment
    {
        return $this->attachment;
    }

    public function getGroup(): Group
    {
        return Initial::getGroupManager()->getGroup($this->groupid);
    }

    public function setGems(int $gems): void
    {
        $this->gems = $gems;
    }

    public function setCoins(int $coins): void
    {
        $this->coins = $coins;
    }

    public function updateGroup(int $groupid, bool $call = true): void
    {
        if ($call) {
            $event = new GroupUpdateEvent($this, $groupid);
            $event->call();
        }
        $this->groupid = $groupid;
        $this->recalculateGroupPermission();
    }

    public function recalculateGroupPermission(): void
    {
        $permissions = $this->getGroup()->getPermissions();
        foreach ($permissions as $permission) {
            $permission = Initial::getPlugin()->getServer()->getPluginManager()->getPermission($permission);
            $this->getAttachment()->clearPermissions();
            $this->getAttachment()->setPermission($permission, true);
        }
    }

    /**
     * @return string
     */
    public function getScoreboardId() : string
    {
        return $this->scoreboardId;
    }


    /**
     * @return Scoreboard
     */
    public function getScoreboard() : Scoreboard
    {
        return Initial::getScoreboardManager()->getScoreboard($this->scoreboardId);
    }

    /**
     * @param string $scoreboardId
     */
    public function setScoreboardId(string $scoreboardId, bool $update = true) : void{
        $this->scoreboardId = $scoreboardId;
        if($update){
            $scoreboard = $this->getScoreboard();
            $scoreboard->sendScore($scoreboard);
        }
    }
}