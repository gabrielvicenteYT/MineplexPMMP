<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use DinoVNOwO\Base\cosmetics\gadgets\GrapplingHook;
use DinoVNOwO\Base\cosmetics\particles\FlawlessAura;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use DinoVNOwO\Base\tasks\ParticleCosmeticsRunner;

class CosmeticsManager extends Manager {

    private $cosmetics = [];

    public function init()
    {
        Initial::getPlugin()->getServer()->getPluginManager()->registerEvents(new CosmeticListener($this), Initial::getPlugin());
        Initial::getPlugin()->getScheduler()->scheduleRepeatingTask(new ParticleCosmeticsRunner($this), 20);
        $this->addCosmetics(new FlawlessAura("flawless_aura", Cosmetic::PARTICLE));
        $this->addCosmetics(new GrapplingHook("grappling_hook", Cosmetic::GADGET));
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