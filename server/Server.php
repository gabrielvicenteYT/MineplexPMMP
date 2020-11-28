<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\server;

use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\events\ServerUpdateListener;
use DinoVNOwO\Base\Initial;

class Server {
    
    public function init() : void{
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::SELECT,
            "servers.find",
            [
                "server_id" => Initial::getConfigManager()->getServerId(),
            ],
            function(array $data) : void{
                if($data === [] || $data[0]["server_id"] !== Initial::getConfigManager()->getServerId()){
                    Initial::getDatabaseManager()->executeAsync(
                        DatabaseManager::INSERT,
                        "servers.insert",
                        [
                            "server_id" => Initial::getConfigManager()->getServerId(),
                            "status" => StatusConst::ONLINE,
                            "players" => count(Initial::getPlugin()->getServer()->getOnlinePlayers()),
                            "max_players" => Initial::getConfigManager()->getMaxPlayers()
                        ]
                    );
                }else{
                    $this->statusUpdate(StatusConst::ONLINE);
                    $this->playerCountUpdate(count(Initial::getPlugin()->getServer()->getOnlinePlayers()));
                }
            }
        );
        Initial::implementEvent(new ServerUpdateListener());
    }

    public function playerCountUpdate(int $players = -1) : void{
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::UPDATE,
            "servers.update.players",
            [
                "server_id" => Initial::getConfigManager()->getServerId(),
                "players" => $players
            ]
        );
    }

    public function statusUpdate(int $status = StatusConst::ONLINE) : void{
        Initial::getDatabaseManager()->executeAsync(
            DatabaseManager::UPDATE,
            "servers.update.status",
            [
                "server_id" => Initial::getConfigManager()->getServerId(),
                "status" => $status
            ]
        );
    }
    
    public function shutdown() : void{
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        $this->statusUpdate(StatusConst::OFFLINE);
        $this->playerCountUpdate(0);
    }
}