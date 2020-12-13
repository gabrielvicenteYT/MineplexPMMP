<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub\items;

use DinoVNOwO\Base\Initial;
use pocketmine\event\Event;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Items{
    
    /**
     * Give player hub items
     *
     * @param  mixed $player
     * @return void
     */
    public static function giveHubItems(Player $player){
        $compass = ItemFactory::get(ItemIds::COMPASS);
        $cosmetics = ItemFactory::get(ItemIds::CHEST);
        $compass->setCustomName(TextFormat::colorize("&r&aQuick Compass"));
        $cosmetics->setCustomName(TextFormat::colorize("&r&aCosmetics Menu"));
        $compass->getNamedTag()->setString("Form", "selector_form");
        $cosmetics->getNamedTag()->setString("Form", "particles_form");
        $player->getInventory()->setItem(0, $compass);
        $player->getInventory()->setItem(4, $cosmetics);
    }
}