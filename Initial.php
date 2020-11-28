<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DinoVNOwO\Base\commands\CommandManager;
use DinoVNOwO\Base\config\ConfigManager;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\group\GroupManager;
use DinoVNOwO\Base\scoreboard\ScoreboardManager;
use DinoVNOwO\Base\server\Server;
use DinoVNOwO\Base\session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

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

    public function __construct(Plugin $plugin){
        self::$plugin = $plugin;
    }

    public function init() : void{
        $config = new Config(\pocketmine\DATA . "server.properties", Config::PROPERTIES);
        if((int) $config->get("server_oobe") !== 1){
            (new FirstStartup())->init();
            $config->set("server_oobe", 1);
            $config->save();
            self::getPlugin()->getServer()->getLogger()->info(TextFormat::colorize("&l&6System&9 >&a Đã hoàn thành startup xong! Bắt đầu khởi động máy chủ"));
        }
        /* MUST EXECUTE FIRST */
        self::$managers[self::CONFIG] = new ConfigManager();
        /* HIGH */
        self::$managers[self::DATABASE] = new DatabaseManager();
        /* LOW */
        self::$managers[self::SESSION] = new SessionManager();
        self::$managers[self::SERVER] = new Server();
        self::$managers[self::COMMAND] = new CommandManager();
        self::$managers[self::GROUP] = new GroupManager();
        self::$managers[self::SCOREBOARD] = new ScoreboardManager();
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
    
    public static function getPlugin() : Plugin{
        return self::$plugin;
    }
}
