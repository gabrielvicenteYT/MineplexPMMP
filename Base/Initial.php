<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DinoVNOwO\Base\commands\CommandManager;
use DinoVNOwO\Base\config\ConfigManager;
use DinoVNOwO\Base\cosmetics\CosmeticsManager;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\forms\Form;
use DinoVNOwO\Base\forms\FormsManager;
use DinoVNOwO\Base\group\GroupManager;
use DinoVNOwO\Base\scoreboard\ScoreboardManager;
use DinoVNOwO\Base\server\Server;
use DinoVNOwO\Base\session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use const pocketmine\DATA;

class Initial{

    protected static $managers = [];

    protected static $plugin;

    public const DATABASE = "database";
    public const CONFIG = "config";
    public const SESSION = "session";
    public const SERVER = "server";
    public const GROUP = "group";
    public const COMMAND = "command";
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
        /* MUST EXECUTE FIRST */
        self::$managers[self::CONFIG] = new ConfigManager();
        /* HIGH */
        self::$managers[self::DATABASE] = new DatabaseManager();
        /* LOW */
        self::$managers[self::SESSION] = new SessionManager();
        self::$managers[self::COMMAND] = new CommandManager();
        self::$managers[self::GROUP] = new GroupManager();
        self::$managers[self::SCOREBOARD] = new ScoreboardManager();
        self::$managers[self::COSMETICS] = new CosmeticsManager();
        self::$managers[self::FORMS] = new FormsManager();
        foreach(self::$managers as $manager){
            $manager->init();
        }
    }
    
    public function shutdown() : void{
        foreach(array_reverse(self::$managers) as $manager){
            if(method_exists(get_class($manager), 'shutdown')){
                $manager->shutdown();
            }
        }
    }
    
    public static function implementEvent(Listener $listener) : void{
        self::getPlugin()->getServer()->getPluginManager()->registerEvents($listener, self::getPlugin());
    }
    
    public static function getConfigManager() : ConfigManager{
        return self::$managers[self::CONFIG];
    }
    
    public static function getDatabaseManager() : DatabaseManager{
        return self::$managers[self::DATABASE];
    }
    
    public static function getSessionManager() : SessionManager{
        return self::$managers[self::SESSION];
    }
    
    public static function getServerManager() : Server{
        return self::$managers[self::SERVER];
    }
    
    public static function getGroupManager() : GroupManager{
        return self::$managers[self::GROUP];
    }
    
    public static function getCommandManager() : CommandManager{
        return self::$managers[self::COMMAND];
    }

    public static function getScoreboardManager() : ScoreboardManager{
        return self::$managers[self::SCOREBOARD];
    }

    public static function getCosmeticsManager() : CosmeticsManager{
        return self::$managers[self::COSMETICS];
    }

    public static function getFormsManager() : FormsManager{
        return self::$managers[self::FORMS];
    }
    
    public static function getPlugin() : Plugin{
        return self::$plugin;
    }
}
