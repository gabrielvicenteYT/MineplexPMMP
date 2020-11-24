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
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        $this->groups[self::NONE] = new Group(self::NONE, "none", "&l&8NONE&r", []);
        $this->groups[self::ULTRA] = new Group(self::ULTRA, "Ultra", "&b&lULTRA&r", []);
        $this->groups[self::HERO] = new Group(self::HERO, "Hero", "&d&lHERO&r", []);
        $this->groups[self::LEGEND] = new Group(self::LEGEND, "Legend", "&a&lLEGEND&r", []);
        $this->groups[self::TITAN] = new Group(self::TITAN, "Titan", "&c&lTITAN&r", []);
        $this->groups[self::TRAINEE] = new Group(self::TRAINEE, "Trainee", "&6&lTRAINEE&r", []);
        $this->groups[self::MOD] = new Group(self::MOD, "Mod", "&6&lMOD&r", []);
        $this->groups[self::BUILDER] = new Group(self::BUILDER, "Builder", "&9&lBUILDER&r", [""]);
        $this->groups[self::ADMIN] = new Group(self::ADMIN, "Admin", "&4&lADMIN&r", ["data.command"]);
        $this->groups[self::DEVELOPER] = new Group(self::DEVELOPER, "Developer", "&4&lDEV&r", ["data.command"]);
        $this->groups[self::OWNER] = new Group(self::OWNER, "Owner", "&4&lOWNER&r", ["data.command"]);
        Initial::implementEvent(new GroupListener());
    }

    public function getGroups() : array{
        return $this->groups;
    }

    public function getGroup(int $group) : ?Group{
        return $this->groups[$group] ?? null;
    }
}