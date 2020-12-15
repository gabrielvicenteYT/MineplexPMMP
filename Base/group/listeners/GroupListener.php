<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\group\listeners;

use DinoVNOwO\Base\group\events\GroupUpdateEvent;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\events\SessionLoadEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat;

class GroupListener implements Listener{

    public function onSessionLoad(SessionLoadEvent $event) : void{
        $session = $event->getSession();
        $session->recalculateGroupPermission();
        $session->getPlayer()->setNameTag(TextFormat::colorize($session->getGroup()->addSpace(false, true) . "&e" . $session->getPlayer()->getName()));
    }

    public function onGroupUpdate(GroupUpdateEvent $event) : void{
        $session = $event->getSession();
        $session->recalculateGroupPermission();
        $session->getPlayer()->setNameTag(TextFormat::colorize($session->getGroup()->addSpace(false, true) . "&e" . $session->getPlayer()->getName()));
    }
    
    public function onChat(PlayerChatEvent $event) : void{
        $session = Initial::getManager(Initial::SESSION)->getSession($event->getPlayer());
        $event->setFormat(TextFormat::colorize($session->getGroup()->addSpace(false, true) . "&e" . $session->getPlayer()->getName() . "&f " . $event->getMessage()));
    }
}