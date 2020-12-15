<?php

declare(strict_types=1);


namespace DinoVNOwO\Base\items;

use pocketmine\item\FishingRod;
use pocketmine\item\ItemFactory;

class ItemManager{

    public function init() : void{
        ItemFactory::registerItem(new FishingRod(), true);
    }
}
