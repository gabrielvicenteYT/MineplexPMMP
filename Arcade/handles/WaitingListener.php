<?php

declare(strict_types=1);

namespace DinoVNOwO\Arcade\handles;

use DinoVNOwO\Arcade\Arcade;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\utils\FormatContainer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class WaitingListener implements Listener{

    public function onJoin(PlayerJoinEvent $event) : void{
        //Check if server is already in progress
        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->removeAllEffects();
        $player->teleport(Initial::getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
        $event->getPlayer()->teleport(Arcade::getInstance()->getLevel()->getSafeSpawn());
        $event->setJoinMessage(FormatContainer::format(FormatContainer::PLAYER_JOIN, ["{name}" => $event->getPlayer()->getName()]));
    }

    public function onQuit(PlayerQuitEvent $event) : void{
        //Check if server is already in progress
        $event->getPlayer()->teleport(Arcade::getInstance()->getLevel()->getSafeSpawn());
        $event->setQuitMessage(FormatContainer::format(FormatContainer::PLAYER_OFFLINE, ["{name}" => $event->getPlayer()->getName()]));
    }
}
