<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\server;

use DinoVNOwO\Base\database\tables\TableData;
use DinoVNOwO\Base\events\ServerUpdateListener;
use DinoVNOwO\Base\Initial;

class Server {
    
    public function init() : void{
        Initial::getDatabaseManager()->getTable(TableData::SERVERS)->insert(0, ["id" => Initial::getConfigManager()->getServerId(), "status" => StatusConst::ONLINE, "players" => count(Initial::getPlugin()->getServer()->getOnlinePlayers()), "maxplayers"=> Initial::getConfigManager()->getPlayersMax()], null, null, true);
        Initial::implementEvent(new ServerUpdateListener());
        $this->statusUpdate(StatusConst::ONLINE);
        $this->playerCountUpdate(count(Initial::getPlugin()->getServer()->getOnlinePlayers()));
    }

    public function playerCountUpdate(int $players = -1) : void{
        Initial::getDatabaseManager()->getTable(TableData::SERVERS)->update("players", ["id" => Initial::getConfigManager()->getServerId(), "players" => $players]);
    }

    public function statusUpdate(int $status = StatusConst::ONLINE) : void{
        Initial::getDatabaseManager()->getTable(TableData::SERVERS)->update("status", ["id" => Initial::getConfigManager()->getServerId(), "status" => $status]);
    }
    
    public function shutdown() : void{
        $this->statusUpdate(StatusConst::OFFLINE);
        $this->playerCountUpdate(0);
    }
}