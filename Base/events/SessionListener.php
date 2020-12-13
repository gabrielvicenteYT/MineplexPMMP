<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\currency\Currency;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener
{

    public function onJoin(PlayerJoinEvent $event): void
    {
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::SELECT,
            "players.find.xuid",
            [
                "xuid" => $event->getPlayer()->getXuid(),
            ],
            function (array $data) use ($event) : void {
                if ($data === []) {
                    $data[0] = ["gems" => 0, "coins" => 0, "group" => 0];
                    Initial::getDatabaseManager()->executeAsync(
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
                    [
                    ],
                    $data[0]["group"],
                    $event->getPlayer()->addAttachment(Initial::getPlugin()),
                    Initial::getScoreboardManager()->getDefaultScoreboardId()
                );
                Initial::getSessionManager()->load($session);
            }
        );
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        Initial::getSessionManager()->destroy(Initial::getSessionManager()->getSession($event->getPlayer()));
    }
}