<?php

declare(strict_types=1);

namespace DinoVNOwO\Arcade\gamemode;

class Duels extends BaseGamemode
{

    public function getId(): string
    {
        return "duels";
    }

    public function getSettings(): array
    {
        return [
            "max" => 2,
            "maps" => []
        ];
    }

    public function onGameTick(): void
    {
        switch ($this->getState()) {
            case BaseGamemode::WAITING:
                if (count($this->getPlayers()) === $this->getSettings()["max"]) {
                    $this->updateState(BaseGamemode::STARTING);
                }
                return;
            case BaseGamemode::STARTING:

                return;
        }
    }
}