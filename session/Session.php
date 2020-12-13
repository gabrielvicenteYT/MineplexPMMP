<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use CortexPE\Commando\args\IntegerArgument;
use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\events\group\GroupUpdateEvent;
use DinoVNOwO\Base\group\Group;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\scoreboard\Scoreboard;
use pocketmine\permission\PermissionAttachment;
use pocketmine\Player;

/**
 * Class Session
 * @package DinoVNOwO\Base\session
 */
class Session
{

    /**
     * @var Player
     */
    protected $player;

    /**
     * @var int
     */
    private $groupid;

    /**
     * @var int
     */
    private $gems;
    /**
     * @var int
     */
    private $coins;

    /**
     * @var PermissionAttachment
     */
    private $attachment;

    /**
     * @var string
     */
    private $scoreboardId;

    /**
     * @var array
     */
    private $activeCosmetics = [];

    private $gemsAdded;
    private $coinsAdded;

    /**
     * Session constructor.
     * @param Player $player
     * @param int $gems
     * @param int $coins
     * @param int $groupid
     * @param PermissionAttachment $attachment
     * @param string $scoreboardId
     */
    public function __construct(Player $player, int $gems, int $coins, int $groupid, PermissionAttachment $attachment, string $scoreboardId)
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

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getGems(): int
    {
        return $this->gems;
    }

    /**
     * @return int
     */
    public function getCoins(): int
    {
        return $this->coins;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupid;
    }

    /**
     * @return PermissionAttachment
     */
    public function getAttachment(): PermissionAttachment
    {
        return $this->attachment;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return Initial::getGroupManager()->getGroup($this->groupid);
    }

    /**
     * @param int $gems
     */
    public function setGems(int $gems): void
    {
        $this->gems = $gems;
    }

    /**
     * @param int $coins
     */
    public function setCoins(int $coins): void
    {
        $this->coins = $coins;
    }

    /**
     * @param int $groupid
     * @param bool $call
     */
    public function updateGroup(int $groupid, bool $call = true): void
    {
        if ($call) {
            $event = new GroupUpdateEvent($this, $groupid);
            $event->call();
        }
        $this->groupid = $groupid;
        $this->recalculateGroupPermission();
    }

    /**
     *
     */
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
    public function getScoreboardId(): string
    {
        return $this->scoreboardId;
    }


    /**
     * @return Scoreboard
     */
    public function getScoreboard(): Scoreboard
    {
        return Initial::getScoreboardManager()->getScoreboard($this->scoreboardId);
    }

    /**
     * @param string $scoreboardId
     * @param bool $update
     */
    public function setScoreboardId(string $scoreboardId, bool $update = true): void
    {
        $this->scoreboardId = $scoreboardId;
        if ($update) {
            $scoreboard = $this->getScoreboard();
            $scoreboard->sendScore($this);
        }
    }

    /**
     * @return array
     */
    public function getActiveCosmetics(): array
    {
        return $this->activeCosmetics;
    }

    /**
     * @param string $type
     * @param string $id
     * @return bool
     */
    public function isActiveCometic(string $type, string $id): bool
    {
        if($this->getCosmetic($type) === null){
            return false;
        }
        return $this->getCosmetic($type)->getId() === $id;
    }

    public function getCosmetic(string $type) : ?Cosmetic
    {
        return Initial::getCosmeticsManager()->getCosmetic($type, $this->activeCosmetics[$type] ?? "not_found");
    }

    public function setActiveCosmetic(string $type, string $id) : bool
    {
        $current = $this->getCosmetic($type);
        if($this->isActiveCometic($type, $id)){
            $current->removeSession($this);
            $this->activeCosmetics[$type] = "not_found";
            return false;
        }
        $active = Initial::getCosmeticsManager()->getCosmetic($type, $id);
        if($current !== null){
            $current->removeSession($this);
        }
        $active->addSession($this);
        $this->activeCosmetics[$type] = $id;
        return true;
    }
}