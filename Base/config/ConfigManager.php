<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\config;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\Manager;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use const pocketmine\DATA;

class ConfigManager extends Manager {

    /* This look useless... */

    private $databaseInformation;
    private $serverId;
    private $serverType;

    /**
     * Init Config Manager
     *
     * @return void
     */
    public function init() : void{
        $config = new Config(DATA. "server.yml", Config::YAML);
        $this->serverId = $config->get("server_id");
        $this->databaseInformation = $config->get("database");
        $this->serverType = $config->get("server_type");
        Initial::getPlugin()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&a This server is running as " . $this->serverId));
    }

    /**
     * @return array
     */
    public function getDatabaseInformation() : array
    {
        return $this->databaseInformation;
    }

    /**
     * @return string
     */
    public function getServerId() : string
    {
        return $this->serverId;
    }

    /**
     * @return string
     */
    public function getServerType() : string
    {
        return $this->serverType;
    }
}