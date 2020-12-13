<?php

namespace DinoVNOwO\Base\commands;

use CortexPE\Commando\BaseCommand as Base;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\utils\FormatContainer;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class BaseCommand extends Base{
	
	protected function prepare() : void{
		$this->setPermissionMessage(TextFormat::colorize(FormatContainer::PERMISSION_NOT_FOUND));
		$this->setErrorFormat(Base::ERR_NO_ARGUMENTS, TextFormat::colorize(FormatContainer::ARGUMENT_MISSING));
		$this->setErrorFormat(Base::ERR_INSUFFICIENT_ARGUMENTS, TextFormat::colorize(FormatContainer::ARGUMENT_MISSING));
		$this->setErrorFormat(Base::ERR_INVALID_ARG_VALUE, TextFormat::colorize(FormatContainer::ARGUMENT_INVALID));
		$this->setErrorFormat(Base::ERR_TOO_MANY_ARGUMENTS, TextFormat::colorize(FormatContainer::ARGUMENT_TOO_MANY));
	}
	
    public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void {
	}

	public function parseArgs(array $args) : array{
		foreach($args as $key => $value){
			if(is_string($value)){
				if($key === "player"){
					$args[$key] = Initial::getPlugin()->getServer()->getPlayerExact($value);
				}else{
					$args[$key] = strtolower($value);
				}
			}
		}
		return $args;
	}
}