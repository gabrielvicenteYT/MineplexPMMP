<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\server;

use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\events\ServerUpdateListener;
use DinoVNOwO\Base\Initial;

class Server {
    
    public function init() : void{
        echo "init server\n";
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        Initial::getDatabaseManager()->execute(
            DatabaseManager::SELECT,
            "servers.find",
            [
                "server_id" => Initial::getConfigManager()->getServerId(),
            ],
            function(array $data) : void{
                if($data === []){
                    Initial::getDatabaseManager()->execute(
                        DatabaseManager::INSERT,
                        "servers.insert",
                        [
                            "server_id" => Initial::getConfigManager()->getServerId(),
                            "status" => StatusConst::ONLINE,
                            "players" => count(Initial::getPlugin()->getServer()->getOnlinePlayers()),
                            "max_players" => Initial::getPlugin()->getServer()->getMaxPlayers()
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
        Initial::getDatabaseManager()->execute(
            DatabaseManager::UPDATE,
            "servers.update.players",
            [
                "server_id" => Initial::getConfigManager()->getServerId(),
                "players" => $players
            ]
        );
    }

    public function statusUpdate(int $status = StatusConst::ONLINE) : void{
        Initial::getDatabaseManager()->execute(
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