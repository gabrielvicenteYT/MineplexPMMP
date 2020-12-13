<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\database\tables\TableData;
use DinoVNOwO\Base\events\session\SessionDestroyEvent;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\scoreboard\ScoreboardManager;
use DinoVNOwO\Base\session\Session;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener
{

    /**
     * Handle session on destroy
     *
     * @param mixed $event
     * @return void
     * @priority LOWEST
     */
    public function onSessionDestroy(SessionDestroyEvent $event): void
    {
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::UPDATE,
            "players.update.xuid.coins",
            [
                "xuid" => $event->getSession()->getPlayer()->getXuid(),
                "coins" => $event->getSession()->getCoins()
            ]
        );
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::UPDATE,
            "players.update.xuid.gems",
            [
                "xuid" => $event->getSession()->getPlayer()->getXuid(),
                "gems" => $event->getSession()->getGems()
            ]
        );
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::UPDATE,
            "players.update.xuid.group",
            [
                "xuid" => $event->getSession()->getPlayer()->getXuid(),
                "group" => $event->getSession()->getGroupId()
            ]
        );
    }


    /**
     * onJoin
     *
     * @param mixed $event
     * @return void
     * @priority LOWEST
     */
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
                $session = new Session($event->getPlayer(), $data[0]["gems"], $data[0]["coins"], $data[0]["group"], $event->getPlayer()->addAttachment(Initial::getPlugin()), Initial::getScoreboardManager()->getDefaultScoreboard()->getId());
                Initial::getSessionManager()->load($session);
            }
        );
    }

    /**
     * onQuit
     *
     * @param mixed $event
     * @return void
     * @priority LOWEST
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        Initial::getSessionManager()->destroy(Initial::getSessionManager()->getSession($event->getPlayer()));
    }
}