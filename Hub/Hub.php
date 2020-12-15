<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub;

use DinoVNOwO\Base\cosmetics\CosmeticsManager;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Hub\forms\ParticlesForm;
use DinoVNOwO\Hub\forms\SelectorForms;
use DinoVNOwO\Hub\listeners\HubListener;
use DinoVNOwO\Hub\scoreboard\HubScoreboard;
use pocketmine\plugin\PluginBase;

class Hub extends PluginBase{

    private static $initial;

    public const PARKOUR = "parkour";
    public const COSMETICS = "cosmetics";

    public function onEnable(){
        self::$initial = new Initial($this);
        self::$initial->init();
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        Initial::registerManager(self::COSMETICS, new CosmeticsManager());
        self::$initial->implementEvent(new HubListener());
        Initial::getManager(Initial::SCOREBOARD)->addScoreboard(new HubScoreboard(), true, true);
        Initial::getManager(Initial::FORMS)->addForm(new ParticlesForm());
        Initial::getManager(Initial::FORMS)->addForm(new SelectorForms());
    }

    public function onDisable(){
        self::$initial->shutdown();
    }
}
