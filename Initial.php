<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DinoVNOwO\Base\config\ConfigManager;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\group\GroupManager;
use DinoVNOwO\Base\server\Server;
use DinoVNOwO\Base\session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

class Initial{

    protected static $managers = [];

    protected static $plugin;

    public const DATABASE = "database";
    public const CONFIG = "config";
    public const SESSION = "session";
    public const SERVER = "server";
    public const GROUP = "group";

    public function __construct(Plugin $plugin){
        self::$plugin = $plugin;
    }
    
    /**
     * init
     *
     * @return void
     */
    public function init() : void{
        /* MUST EXECUTE FIRST */
        self::$managers[self::CONFIG] = new ConfigManager();
        /* HIGH */
        self::$managers[self::DATABASE] = new DatabaseManager();
        /* LOW */
        self::$managers[self::SESSION] = new SessionManager();
        self::$managers[self::SERVER] = new Server();
        self::$managers[self::GROUP] = new GroupManager();
        foreach(self::$managers as $manager){
            $manager->init();
        }
    }
    
    /**
     * shutdown
     *
     * @return void
     */
    public function shutdown() : void{
        foreach(self::$managers as $manager){
            if(method_exists(get_class($manager), 'shutdown')){
                $manager->shutdown();
            }
        }
    }
    
    /**
     * implementEvent
     *
     * @param  mixed $listener
     * @return void
     */
    public static function implementEvent(Listener $listener) : void{
        self::getPlugin()->getServer()->getPluginManager()->registerEvents($listener, self::getPlugin());
    }
    
    /**
     * getConfigManager
     *
     * @return ConfigManager
     */
    public static function getConfigManager() : ConfigManager{
        return self::$managers[self::CONFIG];
    }
    
    /**
     * getDatabaseManager
     *
     * @return DatabaseManager
     */
    public static function getDatabaseManager() : DatabaseManager{
        return self::$managers[self::DATABASE];
    }
    
    /**
     * getSessionManager
     *
     * @return SessionManager
     */
    public static function getSessionManager() : SessionManager{
        return self::$managers[self::SESSION];
    }
    
    /**
     * getServerManager
     *
     * @return Server
     */
    public static function getServerManager() : Server{
        return self::$managers[self::SERVER];
    }
    
    /**
     * getGroupManager
     *
     * @return Server
     */
    public static function getGroupManager() : GroupManager{
        return self::$managers[self::GROUP];
    }
    
    /**
     * getPlugin
     *
     * @return Plugin
     */
    public static function getPlugin() : Plugin{
        return self::$plugin;
    }
}
