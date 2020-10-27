<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database;

use DinoVNOwO\Base\Initial;
use DirectoryIterator;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class DatabaseManager{

    protected $connection;
    
    /**
     * Init database
     *
     * @return void
     */
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
    }
    
    /**
     * Shutdown database
     *
     * @return void
     */
    public function shutdown() : void{
        // Oh no $this->connection->close();
    }
    
    /**
     * Get database connection
     *
     * @return DataConnector
     */
    public function getConnection() : DataConnector{
        return $this->connection;
    }
}