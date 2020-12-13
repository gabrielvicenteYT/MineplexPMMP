<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use DinoVNOwO\Base\cosmetics\particles\FlawlessAura;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\tasks\ParticleCosmeticsRunner;

class CosmeticsManager{

    private $cosmetics = [];

    public function init()
    {
        Initial::getPlugin()->getScheduler()->scheduleRepeatingTask(new ParticleCosmeticsRunner($this), 20);
        $this->addCosmetics(new FlawlessAura("flawless_aura", Cosmetic::PARTICLE));
    }

    private function addCosmetics(Cosmetic $cosmetic) : void{
        $this->cosmetics[$cosmetic->getType()][$cosmetic->getId()] = $cosmetic;
    }

    public function getCosmetic(string $type, string $id) : ?Cosmetic
    {
        return $this->cosmetics[$type][$id] ?? null;
    }

    public function getCosmeticGroup(string $type) : array{
        return $this->cosmetics[$type];
    }
}