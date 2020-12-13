<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\config;

use DinoVNOwO\Base\Initial;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use const pocketmine\DATA;

class ConfigManager{

    /* This look useless... */

    private $databaseInformation;
    private $serverId;
    private $maxPlayers;
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
        $this->maxPlayers = $config->get("max_players");
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
     * @return int
     */
    public function getMaxPlayers() : int
    {
        return $this->maxPlayers;
    }

    /**
     * @return string
     */
    public function getServerType() : string
    {
        return $this->serverType;
    }
}