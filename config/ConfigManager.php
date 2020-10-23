<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\config;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use ReflectionClass;

class ConfigManager{

    /* This look useless... */

    private $databaseinfo;
    private $serverid;

    public function init() : void{
        $config = new Config(Initial::getPlugin()->getServer()->getFilePath() . "server.yml", Config::YAML);
        if($config->get("id") === "undefined"){
            Initial::getPlugin()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&c Config your file!"));
            Initial::getPlugin()->getServer()->shutdown();
        }
        $this->serverid = $config->get("id");
        $this->databaseinfo = $config->get("database");
        Initial::getPlugin()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&a This server is running as " . $this->serverid));
    }

    public function getServerId() : string{
        return $this->serverid;
    }

    public function getDatabaseInformation() : array{
        return $this->databaseinfo;
    }
}