<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database;

use DinoVNOwO\Base\database\tables\Table;
use DinoVNOwO\Base\database\tables\TableData;
use DinoVNOwO\Base\Initial;
use DirectoryIterator;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class DatabaseManager{

    protected $connection;

    protected $tables = [];
    
    public function init() : void{
        $this->connection = libasynql::create(Initial::getPlugin(), 
        Initial::getConfigManager()->getDatabaseInformation(), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        foreach (new DirectoryIterator(dirname(__DIR__, 1) . "\sql_maps") as $sql_map) {
            if($sql_map->isDot() || $sql_map->getExtension() !== "sql"){
                continue;
            }
            $this->connection->loadQueryFile(fopen($sql_map->getPathname(), "rb"), $sql_map->getFilename());
        }
        /* So good yes */
        $this->connection->executeSelect("utilities.search_table", ["table_name" => "servers"], 
        function(array $data){
            if($data === []){
                $this->connection->executeGeneric("tables.servers");
            }
        });
        $this->connection->executeSelect("utilities.search_table", ["table_name" => "players"], 
        function(array $data){
            if($data === []){
                $this->connection->executeGeneric("tables.players");
            }
        });
        
        $this->tables[TableData::SERVERS] = new Table(
            [
                TableData::INSERT => ["servers.insert"],
                TableData::FIND => ["servers.find"],
                TableData::UPDATE => [
                    "status" => "servers.update.status",
                    "players" => "servers.update.players",
                    "maxplayers" => "servers.update.maxplayers"
                ]
            ]
        );
        $this->tables[TableData::PLAYERS] = new Table(
            [
                TableData::INSERT => ["players.insert"],
                TableData::FIND => ["players.find"],
                TableData::UPDATE => [
                    "gems" => "players.update.gems",
                    "coins" => "players.update.coins",
                    "group" => "players.update.group"
                ]
            ]
        );
    }
    
    public function shutdown() : void{
        $this->connection->close();
    }

    public function getTable(string $table) : ?Table{
        return $this->tables[$table] ?? null;
    }
    
    public function getConnection() : DataConnector{
        return $this->connection;
    }
}