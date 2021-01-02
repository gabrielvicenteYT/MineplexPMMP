<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\currency\Currency;
use DinoVNOwO\Base\group\events\GroupUpdateEvent;
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
    /**
     * @var array
     */
    private $currencies = [];

    /**
     * Session constructor.
     * @param Player $player
     * @param array $currencies
     * @param int $groupid
     * @param PermissionAttachment $attachment
     * @param string $scoreboardId
     * @param array $activeCosmetics
     */
    public function __construct(Player $player, array $currencies = [], int $groupid, PermissionAttachment $attachment, string $scoreboardId, array $activeCosmetics = [Cosmetic::GADGET => "not_found", Cosmetic::PARTICLE => "not_found", Cosmetic::PETS => "not_found"])
    {
        $this->player = $player;
        $this->groupid = $groupid;
        $this->attachment = $attachment;
        $this->scoreboardId = $scoreboardId;
        $this->currencies = $currencies;
        $this->getAttachment()->clearPermissions();
        if($this->getScoreboard() !== null){
            $this->getScoreboard()->sendScore($this);
        }
        if(Initial::getManager(Initial::COSMETICS) !== null){
            foreach($activeCosmetics as $type => $id){
                $this->setActiveCosmetic($type, $id);
            }
        }
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
        return Initial::getManager(Initial::GROUP)->getGroup($this->groupid);
    }

    public function getCurrencies() : array{
        return $this->currencies;
    }

    public function getCurrency(string $id) : ?Currency{
        return $this->currencies[$id] ?? null;
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
    public function getScoreboard(): ?Scoreboard
    {
        return Initial::getManager(Initial::SCOREBOARD)->getScoreboard($this->scoreboardId);
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
        return Initial::getManager(Initial::COSMETICS)->getCosmetic($type, $this->activeCosmetics[$type] ?? "not_found");
    }

    public function setActiveCosmetic(string $type, string $id) : bool
    {
        $current = $this->getCosmetic($type);
        if($this->isActiveCometic($type, $id)){
            $current->removeSession($this);
            $this->activeCosmetics[$type] = "not_found";
            return false;
        }
        $active = Initial::getManager(Initial::COSMETICS)->getCosmetic($type, $id);
        var_dump($active);
        if($current !== null){
            $current->removeSession($this);
        }
        $active->addSession($this);
        $this->activeCosmetics[$type] = $id;
        return true;
    }
}