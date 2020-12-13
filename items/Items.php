<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\items;

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
        $lobby = ItemFactory::get(ItemIds::CLOCK);
        $cosmetics = ItemFactory::get(ItemIds::CHEST);
        $compass->setCustomName(TextFormat::colorize("&r&aQuick Compass"));
        $lobby->setCustomName(TextFormat::colorize("&r&aLobby Menu"));
        $cosmetics->setCustomName(TextFormat::colorize("&r&aCosmetics Menu"));
        $compass->getNamedTag()->setString("Form", "compassForm");
        $lobby->getNamedTag()->setString("Form", "lobbyForm");
        $cosmetics->getNamedTag()->setString("Form", "particles_form");
        $player->getInventory()->setItem(0, $compass);
        $player->getInventory()->setItem(1, $lobby);
        $player->getInventory()->setItem(4, $cosmetics);
    }

    public static function formHandle(Event $event) : void{
        if($event->getItem()->getNamedTag()->hasTag("Form") !== null){
            $event->setCancelled();
            $session = Initial::getSessionManager()->getSession($event->getPlayer());
            Initial::getFormsManager()->getForm($event->getItem()->getNamedTag()->getString("Form"))->send($session);
        }
    }
}