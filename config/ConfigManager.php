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
    private $playersmax;
    
    /**
     * Init Config Manager
     *
     * @return void
     */
    public function init() : void{
        $config = new Config(Initial::getPlugin()->getServer()->getFilePath() . "server.yml", Config::YAML);
        if($config === null)
        if($config->get("id") === "undefined"){
            Initial::getPlugin()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&c Config your file!"));
            Initial::getPlugin()->getServer()->shutdown();
        }
        $this->serverid = $config->get("id");
        $this->databaseinfo = $config->get("database");
        $this->playersmax = $config->get("playersmax");
        Initial::getPlugin()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&a This server is running as " . $this->serverid));
    }
    
    /**
     * Return server id
     *
     * @return string
     */
    public function getServerId() : string{
        return $this->serverid;
    }
    
    /**
     * Return database information
     *
     * @return array
     */
    public function getDatabaseInformation() : array{
        return $this->databaseinfo;
    }
    
    /**
     * Return server max players
     *
     * @return int
     */
    public function getPlayersMax() : int{
        return $this->playersmax;
    }
}