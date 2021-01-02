<?php

declare(strict_types=1);

namespace DinoVNOwO\Arcade;

use DinoVNOwO\Arcade\gamemode\BaseGamemode;
use DinoVNOwO\Arcade\gamemode\Duels;
use DinoVNOwO\Arcade\handles\WaitingListener;
use DinoVNOwO\Base\Initial;
use pocketmine\level\Level;
use pocketmine\plugin\PluginBase;

class Arcade extends PluginBase{

    private static $initial;
    private static $instance;

    private $level;
    /**
     * @var BaseGamemode
     */
    private $currentGamemode;

    private $gamemodes = [];

    public function onEnable(){
        $this->getServer()->loadLevel("waiting");
        $level = $this->getServer()->getLevelByName("waiting");
        if(!$level instanceof Level){
            $this->getServer()->shutdown();
            $this->getServer()->getLogger()->info("Arcade > Can't find `waiting` world. Please add one in the worlds folder");
            return;
        }
        self::$instance = $this;
        $this->setLevel($level);
        self::$initial = new Initial($this);
        self::$initial->init();
        Initial::implementEvent(new WaitingListener());
        $this->gamemodes["duels"] = new Duels();
    }

    public function onDisable(){
        if(self::$instance === null){
            return;
        }
        self::$initial->shutdown();
    }

    /**
     * @return Arcade
     */
    public static function getInstance() : Arcade
    {
        return self::$instance;
    }

    public function getLevel() : Level
    {
        return $this->level;
    }

    public function setLevel(Level $level): void
    {
        $this->level = $level;
    }

    public function getCurrentGamemode() : BaseGamemode{
        return $this->currentGamemode;
    }

    public function getGamemode(string $id) : ?BaseGamemode{
        return $this->gamemodes[$id] ?? null;
    }

    public function getGamemodes() : array{
        return $this->gamemodes;
    }
}
