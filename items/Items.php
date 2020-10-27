<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\items;

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
        $lobby = ItemFactory::get(ItemIds::CLOCK);
        $cosmetics = ItemFactory::get(ItemIds::CHEST);
        $compass->setCustomName(TextFormat::colorize("&r&aQuick Compass"));
        $lobby->setCustomName(TextFormat::colorize("&r&aLobby Menu"));
        $cosmetics->setCustomName(TextFormat::colorize("&r&aCosmetics Menu"));
        $compass->getNamedTag()->setString("Form", "compassForm");
        $lobby->getNamedTag()->setString("Form", "lobbyForm");
        $cosmetics->getNamedTag()->setString("Form", "cosmeticsForm");
        $player->getInventory()->setItem(0, $compass);
        $player->getInventory()->setItem(1, $lobby);
        $player->getInventory()->setItem(4, $cosmetics);
    }
}