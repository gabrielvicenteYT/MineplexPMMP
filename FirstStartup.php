<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DirectoryIterator;
use PDO;
use pocketmine\utils\Config;
use poggit\libasynql\libasynql;
use const pocketmine\DATA;

class FirstStartup
{

    public function init(): void
    {
        //Generate config
        $default =
            [
                "server_id" => "Undefined-1",
                "server_type" => 1,
                "max_players" => 20,
                "database" =>
                    [
                        //Only nn use sqlite3
                        "type" => "mysql",
                        "mysql" =>
                            [
                                "host" => "127.0.0.1",
                                "username" => "root",
                                "password" => "",
                                "schema" => "mineplex"
                            ],
                        "worker-limit" => 2
                    ]
            ];
        new Config(DATA . "server.yml", Config::YAML, $default);
        $conn = new PDO("mysql:host=127.0.0.1;dbname=mineplex", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("CREATE TABLE players(`xuid` BIGINT NOT NULL, `name` TEXT NOT NULL, `gems` INT NOT NULL, `coins` INT NOT NULL, `group` INT NOT NULL, PRIMARY KEY(xuid));");
        $conn->exec("CREATE TABLE servers(`server_id` VARCHAR(20) NOT NULL, `status` INT NOT NULL, `players` INT NOT NULL, `max_players` INT NOT NULL, PRIMARY KEY(server_id));");
    }
}