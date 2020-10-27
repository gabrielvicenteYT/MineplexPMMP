<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\server;

use DinoVNOwO\Base\events\ServerUpdateListener;
use DinoVNOwO\Base\Initial;

class Server {

    public const ONLINE = 1;
    public const OFFLINE = 0;
    
    /**
     * Init server
     *
     * @return void
     */
    public function init() : void{
        Initial::getDatabaseManager()->getConnection()->executeSelect(
            "servers.find", 
            ["id" => Initial::getConfigManager()->getServerId()],
            function(array $data) : void{
                if($data === []){
                    Initial::getDatabaseManager()->getConnection()->executeInsert(
                        "servers.insert", 
                        [
                            "id" => Initial::getConfigManager()->getServerId(),
                            "status" => 1,
                            "players" => count(Initial::getPlugin()->getServer()->getOnlinePlayers()),
                            "maxplayers"=> Initial::getConfigManager()->getPlayersMax(),
                        ]
                    );
                }else{
                    $this->playerCountUpdate(count(Initial::getPlugin()->getServer()->getOnlinePlayers()));
                    $this->statusUpdate(self::ONLINE);
                }
            }
        );
        Initial::implementEvent(new ServerUpdateListener());
    }
    
    /**
     * Update server player count
     *
     * @param  mixed $players
     * @return void
     */
    public function playerCountUpdate(int $players = -1) : void{
        Initial::getDatabaseManager()->getConnection()->executeChange("servers.update.players", ["id" => Initial::getConfigManager()->getServerId(), "players" => $players]);
    }
    
    /**
     * Update server status
     *
     * @param  mixed $status
     * @return void
     */
    public function statusUpdate(int $status = self::ONLINE) : void{
        Initial::getDatabaseManager()->getConnection()->executeChange("servers.update.status", ["id" => Initial::getConfigManager()->getServerId(), "status" => $status]);
    }
    
    /**
     * Shutdown server
     *
     * @return void
     */
    public function shutdown() : void{
        $this->statusUpdate(self::OFFLINE);
        $this->playerCountUpdate(0);
    }
}