<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class CosmeticListener implements Listener
{

    /**
     * @var CosmeticsManager
     */
    private $manager;

    public function __construct(CosmeticsManager $manager){
        $this->manager = $manager;
    }

    public function onInteract(PlayerInteractEvent $event){
        foreach($this->manager->getCosmeticGroup(Cosmetic::GADGET) as $gadget){
            if($event->getItem()->equals($gadget->getItem())){
                $event->setCancelled();
                $gadget->onInteract($event);
            }
        }
    }
}