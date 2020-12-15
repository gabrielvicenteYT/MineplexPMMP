<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\database;

use DinoVNOwO\Base\exceptions\RequestDatabaseException;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use DirectoryIterator;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class DatabaseManager extends Manager
{
    protected $connection;
    public const SELECT = 0;
    public const INSERT = 1;
    public const UPDATE = 2;

    public function init(): void
    {
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        $this->connection = libasynql::create(Initial::getPlugin(),
            Initial::getManager(Initial::CONFIG)->getDatabaseInformation(), [
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

    public function executeAsync(int $request, string $query, array $args, callable $onSuccess = null, callable $onError = null): void
    {
        switch ($request) {
            case self::INSERT:
                Initial::getManager(Initial::DATABASE)->getConnection()->executeInsert($query, $args, $onSuccess, $onError);
                return;
            case self::SELECT:
                Initial::getManager(Initial::DATABASE)->getConnection()->executeSelect($query, $args, $onSuccess, $onError);
                return;
            case self::UPDATE:
                Initial::getManager(Initial::DATABASE)->getConnection()->executeChange($query, $args, $onSuccess, $onError);
                return;
            default:
                throw new RequestDatabaseException("Database request with id $request DOES NOT exist");
                return;
        }
    }
}