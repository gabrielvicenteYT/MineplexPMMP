<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics\gadgets;

use DinoVNOwO\Base\cosmetics\GadgetCosmetics;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use dktapps\pmforms\MenuOption;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerToggleFlightEvent;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;

class GrapplingHook extends GadgetCosmetics
{
    private $cooldown = [];

    public function __construct(string $id, string $type)
    {
        parent::__construct($id, $type);
    }

    public function getMenuOption(): MenuOption
    {
        return new MenuOption("grappling_hook", "");
    }

    public function getItem(): Item
    {
        $item = Item::get(Item::FISHING_ROD, 0, 1);
        $item->setCustomName(TextFormat::colorize("&r&a&lGrappling&e Hook&7 (Right click)"));
        $item->getNamedTag()->setString("cosmetic", $this->getId());
        return $item;
    }

    public function setCooldown(Session $session) : void{
        $this->cooldown[spl_object_hash($session)] = true;
    }

    public function removeCooldown(Session $session) : void{
        unset($this->cooldown[spl_object_hash($session)]);
    }

    public function isCooldown(Session $session) : bool{
        return isset($this->cooldown[spl_object_hash($session)]);
    }

    public function onInteract(PlayerInteractEvent $event): void
    {
        $session = Initial::getManager(Initial::SESSION)->getSession($event->getPlayer());
        if($this->isCooldown($session)){
            if(!$session->getPlayer()->isOnGround()){
                return;
            }
            $this->removeSession($session);
        }
        $vector = $session->getPlayer()->getDirectionVector();
        $session->getPlayer()->setMotion($vector->multiply(5)->setComponents($vector->x, 1, $vector->z));

    }

    public function onFlight(PlayerToggleFlightEvent $event) : void{
    }
}