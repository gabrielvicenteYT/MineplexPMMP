<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\scoreboard;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;

abstract class Scoreboard
{

    private $defaultScoreboard;
    private $removeScoreboardPacket;
    private $entries;


    public function __construct()
    {
        $this->defaultScoreboard = new SetDisplayObjectivePacket();
        $this->defaultScoreboard->displaySlot = "sidebar";
        $this->defaultScoreboard->objectiveName = "objective";
        $this->defaultScoreboard->criteriaName = "dummy";
        $this->defaultScoreboard->sortOrder = 0;
        $this->removeScoreboardPacket = new RemoveObjectivePacket();
        $this->removeScoreboardPacket->objectiveName = "objective";
    }

    abstract public function getId();

    /**
     * @param string $display
     */
    public function setScoreboardDisplayName(string $display, bool $update = true): void
    {
        $this->defaultScoreboard->displayName = $display;
        if($update) {
            foreach (Initial::getPlugin()->getServer()->getOnlinePlayers() as $player) {
                $session = Initial::getManager(Initial::SESSION)->getSession($player);
                if($session->getScoreboardId() === $this->getId()){
                    $this->sendScore($session);
                }
            }
        }
    }

    public function removeFor(Session $session) : void{
        $session->getPlayer()->sendDataPacket($this->defaultScoreboard);
    }

    public function sendScore(Session $session): void
    {
        $this->removeFor($session);
        $session->getPlayer()->sendDataPacket($this->defaultScoreboard);
        $this->updateScore($session);
    }

    public function updateScore(Session $session, array $entries = []): void
    {
        $pk = new SetScorePacket();
        $pk->type = $pk::TYPE_CHANGE;
        $pk->entries = $this->fixEntries($entries);
        $session->getPlayer()->sendDataPacket($pk);
    }

    //Bedrock Scoreboard is retarded
    public function fixEntries(array $entries) : array{
        foreach($entries as $id => $entry){
            $previousEntry = $entries[$id - 1] ?? null;
            if($previousEntry === null){
                continue;
            }
            while($previousEntry->customName === $entry->customName){
                $entry->customName = $entry->customName . " ";
            }
            $entries[$id] = $entry;
        }
        return $entries;
    }
}