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
        $session->getPlayer()->setNameTag(TextFormat::colorize("&80 " . $session->getGroup()->getFormat() . "&e " . $session->getPlayer()->getName()));
    }

    public function onGroupUpdate(GroupUpdateEvent $event) : void{
        $session = $event->getSession();
        $session->getPlayer()->setNameTag(TextFormat::colorize("&80 " . $session->getGroup()->getFormat() . "&e " . $session->getPlayer()->getName()));
        $session->getPlayer()->sendMessage(TextFormat::colorize("&l&6Permissions&8 >&a Your group has been updated"));
    }

    public function onSessionDestroy(SessionDestroyEvent $event) : void{
        $session = $event->getSession();
        $session->getAttachment()->clearPermissions();
    }

    public function onChat(PlayerChatEvent $event) : void{
        $session = Initial::getSessionManager()->getSession($event->getPlayer());
        $event->setFormat(TextFormat::colorize("&80 " . $session->getGroup()->getFormat() . "&e " . $session->getPlayer()->getName() . "&f " . $event->getMessage()));
    }
}