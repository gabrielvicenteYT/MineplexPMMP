<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DinoVNOwO\Base\config\ConfigManager;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\forms\FormsManager;
use DinoVNOwO\Base\group\GroupManager;
use DinoVNOwO\Base\scoreboard\ScoreboardManager;
use DinoVNOwO\Base\session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use const pocketmine\DATA;

class Initial{

    protected static $managers = [];

    protected static $plugin;

    public const DATABASE = "database";
    public const CONFIG = "config";
    public const SESSION = "session";
    public const SERVER = "server";
    public const GROUP = "group";
    public const SCOREBOARD = "scoreboard";
    public const COSMETICS = "cosmetics";
    public const FORMS = "forms";

    public function __construct(Plugin $plugin){
        self::$plugin = $plugin;
    }

    public function init() : void{
        if((int) (new Config(DATA . "server.properties", Config::PROPERTIES))->get("server_oobe") !== 1){
            new Config(DATA . "server.yml", Config::YAML, [
                "server_id" => "Undefined-1",
                "server_type" => 1,
                "max_players" => 20,
                "database" =>
                    [
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
            ]);
        }

        //HIGH
        self::registerManager(self::CONFIG, new ConfigManager());
        self::registerManager(self::DATABASE, new DatabaseManager());
        self::registerManager(self::SESSION, new SessionManager());

        //MEDIUM
        //self::registerManager(self::MEDIUM, new CommandManager());
        self::registerManager(self::GROUP, new GroupManager());
        self::registerManager(self::SCOREBOARD, new ScoreboardManager());
        self::registerManager(self::FORMS, new FormsManager());
    }
    
    public function shutdown() : void{
        foreach(array_reverse(self::$managers) as $pos => $managers){
            foreach ($managers as $manager){
                if(method_exists("shutdown", $manager)) {
                    $manager->shutdown();
                }
            }
        }
    }
    
    public static function implementEvent(Listener $listener) : void{
        self::getPlugin()->getServer()->getPluginManager()->registerEvents($listener, self::getPlugin());
    }

    public static function registerManager(string $id, Manager $manager) : void{
        self::$managers[$id] = $manager;
        $manager->init();
    }

    public static function getManager(string $id) : ?Manager{
        return self::$managers[$id] ?? null;
    }

    public static function getPlugin() : Plugin{
        return self::$plugin;
    }
}
