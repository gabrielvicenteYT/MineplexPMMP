<?php

declare(strict_types=1);

namespace DinoVNOwO\Base;

use DinoVNOwO\Base\config\ConfigManager;
use DinoVNOwO\Base\database\DatabaseManager;
use DinoVNOwO\Base\session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

class Initial{

    protected static $managers = [];

    protected static $plugin;

    public const DATABASE = "database";
    public const CONFIG = "config";
    public const SESSION = "session";

    public function __construct(Plugin $plugin){
        self::$plugin = $plugin;
    }

    public function init() : void{
        self::$managers[self::CONFIG] = new ConfigManager();
        self::$managers[self::DATABASE] = new DatabaseManager();
        self::$managers[self::SESSION] = new SessionManager();
        foreach(self::$managers as $manager){
            $manager->init();
        }
    }

    public function shutdown() : void{
        foreach(self::$managers as $manager){
            if(method_exists(get_class($manager), 'shutdown')){
                $manager->shutdown();
            }
        }
    }

    public function implementEvent(Listener $listener) : void{
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

    public static function getPlugin() : Plugin{
        return self::$plugin;
    }
}
