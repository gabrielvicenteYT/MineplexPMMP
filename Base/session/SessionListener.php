<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\session;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\Initial;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener
{

    public function onJoin(PlayerJoinEvent $event): void
    {
        Initial::getManager(Initial::DATABASE)->executeAsync(
            DatabaseManager::SELECT,
            "players.find.xuid",
            [
                "xuid" => $event->getPlayer()->getXuid(),
            ],
            function (array $data) use ($event) : void {
                if ($data === []) {
                    $data[0] = ["gems" => 0, "coins" => 0, "group" => 0];
                    Initial::getManager(Initial::DATABASE)->executeAsync(
                        DatabaseManager::INSERT,
                        "players.insert",
                        [
                            "xuid" => $event->getPlayer()->getXuid(),
                            "name" => $event->getPlayer()->getName(),
                            "coins" => 0,
                            "gems" => 0,
                            "group" => 0
                        ]
                    );
                }
                $session = new Session(
                    $event->getPlayer(),
                    [],
                    $data[0]["group"],
                    $event->getPlayer()->addAttachment(Initial::getPlugin()),
                    Initial::getManager(Initial::SCOREBOARD)->getDefaultScoreboardId(),
                    [Cosmetic::GADGET => "grappling_hook"]
                );
                Initial::getManager(Initial::SESSION)->load($session);
                $session->setActiveCosmetic(Cosmetic::GADGET, "grappling_hook");
            }
        );
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        Initial::getManager(Initial::SESSION)->destroy(Initial::getManager(Initial::SESSION)->getSession($event->getPlayer()));
    }
}