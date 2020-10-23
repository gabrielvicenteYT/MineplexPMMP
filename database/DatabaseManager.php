<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database;

use DinoVNOwO\Base\Initial;
use DirectoryIterator;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class DatabaseManager{

    protected $connection;

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
    }

    public function shutdown() : void{
        $this->connection->close();
    }

    public function getConnection() : DataConnector{
        return $this->connection;
    }
}