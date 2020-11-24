<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\commands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\PacketHooker;
use DinoVNOwO\Base\Initial;
use pocketmine\permission\Permission;

class CommandManager{

    public function init() : void{
        if(!Initial::getPlugin()->getServer()->isRunning()){
            return;
        }
        if(!PacketHooker::isRegistered()) {
            PacketHooker::register(Initial::getPlugin());
        }
        Initial::getPlugin()->getServer()->getPluginManager()->addPermission(new Permission("data.command", "Allow to use data command", Permission::DEFAULT_OP));
    }
}