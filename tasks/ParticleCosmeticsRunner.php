<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\tasks;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\cosmetics\CosmeticsManager;
use pocketmine\scheduler\Task;

class ParticleCosmeticsRunner extends Task
{

    private $manager;

    public function __construct(CosmeticsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function onRun(int $currentTick)
    {
        foreach($this->manager->getCosmeticGroup(Cosmetic::PARTICLE) as $particle){
            $particle->sendParticle();
        }
    }
}