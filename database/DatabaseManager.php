<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database;

use DinoVNOwO\Base\Initial;
use DirectoryIterator;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class DatabaseManager
{
    protected $connection;

    public const INSERT = "insert";
    public const SELECT = "select";
    public const UPDATE = "update";

    public function init(): void
    {
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        $this->connection = libasynql::create(Initial::getPlugin(),
            Initial::getConfigManager()->getDatabaseInformation(), [
                "sqlite" => "sqlite.sql",
                "mysql" => "mysql.sql"
            ]);
        foreach (new DirectoryIterator(dirname(__DIR__, 1) . "\sql_maps") as $sql_map) {
            if ($sql_map->isDot() || $sql_map->getExtension() !== "sql") {
                continue;
            }
            $this->connection->loadQueryFile(fopen($sql_map->getPathname(), "rb"), $sql_map->getFilename());
        }
    }

    public function shutdown(): void
    {
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        $this->connection->close();
    }

    public function getConnection(): DataConnector
    {
        return $this->connection;
    }

    public function executeAsync(string $request, string $query, array $args, callable $onSuccess = null, callable $onError = null): void
    {
        switch ($request) {
            case self::INSERT:
                Initial::getDatabaseManager()->getConnection()->executeInsert($query, $args, $onSuccess, $onError);
                return;
            case self::SELECT:
                Initial::getDatabaseManager()->getConnection()->executeSelect($query, $args, $onSuccess, $onError);
                return;
            case self::UPDATE:
                Initial::getDatabaseManager()->getConnection()->executeChange($query, $args, $onSuccess, $onError);
                return;
            default:
                throw new TableException("Database request with name $request DOES NOT exist");
                return;
        }
    }
}