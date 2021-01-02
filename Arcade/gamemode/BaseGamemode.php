<?php

declare(strict_types=1);

namespace DinoVNOwO\Arcade\gamemode;

use pocketmine\Player;

abstract class BaseGamemode
{

    public const WAITING = 0;
    public const STARTING = 1;
    public const RUNNING = 2;
    public const ENDING = 3;

    private $ticks = 0;

    private $state;

    private $players = [];

    abstract public function getId(): string;

    abstract public function getSettings(): array;

    public function getState() : int
    {
        return $this->state;
    }

    public function updateState(int $state) : bool
    {
        $event = new GameStateUpdateEvent($this, $state);
        if($event->isCancelled()){
            return false;
        }
        $this->state = $state;
        return true;
    }

    public function getGameTick(): int
    {
        return $this->ticks;
    }

    public function onGameTick(): void
    {
        $this->ticks++;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[spl_object_hash($player)] = $player;
    }

    public function removePlayer(Player $player): void
    {
        unset($this->players[spl_object_hash($player)]);
    }

    public function isInGame(Player $player): bool
    {
        return isset($this->players[spl_object_hash($player)]);
    }

    public function getPlayers() : array{
        return $this->players;
    }

    public function onGameJoin(PlayerJoinGameEvent $event): void
    {
    }

    public function onGameQuit(PlayerQuitGameEvent $event): void
    {
    }

    public function onGameStateUpdate(GameStateUpdateEvent $event): void
    {
    }
}