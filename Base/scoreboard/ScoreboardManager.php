<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\scoreboard;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;

class ScoreboardManager extends Manager {

    /**
     * @var array
     */
    private $scoreboard = [];
    /**
     * @var string
     */
    private $default = "not_found";

    public function init()
    {
    }

    public function sendToAll(string $id = null) : void{
        $scoreboard = $this->getScoreboard($id);
        if($scoreboard === null){
            $scoreboard = $this->getDefaultScoreboard();
        }
        foreach(Initial::getPlugin()->getServer()->getOnlinePlayers() as $player){
            $session = Initial::getManager(Initial::SESSION)->getSession($player);
            $scoreboard->sendScore($session);
        }
    }

    public function removeForAll() : void{
        foreach(Initial::getPlugin()->getServer()->getOnlinePlayers() as $player){
            $session = Initial::getManager(Initial::SESSION)->getSession($player);
            $removeScoreboardPacket = new RemoveObjectivePacket();
            $removeScoreboardPacket->objectiveName = "objective";
            $session->getPlayer()->sendDataPacket($removeScoreboardPacket);
        }
    }

    public function addScoreboard(Scoreboard $scoreboard, bool $default = false, bool $updateIfDefault = true) : void{
        $this->scoreboard[$scoreboard->getId()] = $scoreboard;
        if($default){
            $this->setDefaultScoreboard($scoreboard->getId(), $updateIfDefault);
        }
    }

    /**
     * @param string $id
     * @return Scoreboard|null
     */
    public function getScoreboard(string $id) : ?Scoreboard{
        return $this->scoreboard[$id] ?? null;
    }

    /**
     * @param string $id
     */
    public function setDefaultScoreboard(string $id, bool $updateIfDefault = true) : void{
        $this->default = $id;
        if($updateIfDefault){
            $this->sendToAll($id);
        }
    }

    /**
     * @return Scoreboard
     */
    public function getDefaultScoreboard(): ?Scoreboard
    {
        return $this->getScoreboard($this->default);
    }

    /**
     * @return string
     */
    public function getDefaultScoreboardId(): string
    {
        return $this->default;
    }
}