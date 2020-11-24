<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\events\group\GroupUpdateEvent;
use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\events\session\SessionLoadEvent;
use DinoVNOwO\Base\Initial;
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
        $session = Initial::getSessionManager()->getSession($event->getPlayer());
        $event->setFormat(TextFormat::colorize($session->getGroup()->addSpace(false, true) . "&e" . $session->getPlayer()->getName() . "&f " . $event->getMessage()));
    }
}