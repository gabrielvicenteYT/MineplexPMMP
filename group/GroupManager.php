<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\group;

use DinoVNOwO\Base\events\group\GroupUpdateEvent;
use DinoVNOwO\Base\events\GroupListener;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class GroupManager{

    /* Haha broke people */
    public const NONE = 0;
    public const ULTRA = 1;
    public const HERO = 2;
    public const LEGEND = 3;
    /* Ultra rich people. POG */
    public const TITAN = 4;
    public const TRAINEE = 5;
    public const MOD = 6;
    public const BUILDER = 7;
    public const ADMIN = 8;
    public const DEVELOPER = 9;
    public const OWNER = 10;

    protected $groups = [];

    public function init() : void{
        $this->groups[self::NONE] = new Group(self::NONE, "&e&r", []);
        $this->groups[self::ULTRA] = new Group(self::ULTRA, "&b&lULTRA&r", []);
        $this->groups[self::HERO] = new Group(self::HERO, "&d&lHERO&r", []);
        $this->groups[self::LEGEND] = new Group(self::LEGEND, "&a&lLEGEND&r", []);
        $this->groups[self::TITAN] = new Group(self::TITAN, "&c&lTITAN&r", []);
        $this->groups[self::TRAINEE] = new Group(self::TRAINEE, "&6&lTRAINEE&r", []);
        $this->groups[self::MOD] = new Group(self::MOD, "&6&lMOD&r", []);
        $this->groups[self::BUILDER] = new Group(self::BUILDER, "&9&lBUILDER&r", ["pocketmine.command.ban.player"]);
        $this->groups[self::ADMIN] = new Group(self::ADMIN, "&4&lADMIN&r", ["pocketmine.command.ban.player"]);
        $this->groups[self::DEVELOPER] = new Group(self::DEVELOPER, "&4&lDEV&r", ["*"]);
        $this->groups[self::OWNER] = new Group(self::OWNER, "&4&lOWNER&r", ["*"]);
        Initial::implementEvent(new GroupListener());
    }

    public function getGroups() : array{
        return $this->groups;
    }

    public function getGroup(int $group) : ?Group{
        return $this->groups[$group] ?? null;
    }

    public function updateGroup(Session $session, int $groupid, bool $call = true) : void{
        $group = $this->getGroup($groupid);
        if($group === null){
            Initial::getPlugin()->getLogger(TextFormat::colorize("&6Logger&8 >&c Can't update " . $session->getPlayer()->getName() . "'s session (rank)"));
            return;
        }
        if($call){
            $event = new GroupUpdateEvent($session, $groupid);
            $event->call();
        }
        $session->setGroupId($groupid);
        $this->recalculatePermission($session);
    }

    public function recalculatePermission(Session $session){
        $permissions = $session->getGroup()->getPermissions();
        foreach($permissions as $permission){
            $permission = Initial::getPlugin()->getServer()->getPluginManager()->getPermission($permission);
            $session->getAttachment()->clearPermissions();
            $session->getAttachment()->setPermission($permission, true);
        }
    }
}