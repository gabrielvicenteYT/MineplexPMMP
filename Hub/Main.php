<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Hub\forms\ParticlesForm;
use DinoVNOwO\Hub\forms\SelectorForms;
use DinoVNOwO\Hub\listeners\HubListener;
use DinoVNOwO\Hub\scoreboard\HubScoreboard;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    private static $initial;

    public function onEnable(){
        self::$initial = new Initial($this);
        self::$initial->init();
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        self::$initial->implementEvent(new HubListener());
        Initial::getScoreboardManager()->addScoreboard(new HubScoreboard(), true, true);
        Initial::getFormsManager()->addForm(new ParticlesForm());
        Initial::getFormsManager()->addForm(new SelectorForms());
    }

    public function onDisable(){
        self::$initial->shutdown();
    }
}
