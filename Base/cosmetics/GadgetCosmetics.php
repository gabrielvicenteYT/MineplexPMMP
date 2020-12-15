<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use DinoVNOwO\Base\session\Session;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;

abstract class GadgetCosmetics extends Cosmetic
{

    private $session = [];

    public function __construct(string $id, string $type)
    {
        parent::__construct($id, $type);
    }

    public function addSession(Session $session) : void{
        $session->getPlayer()->getInventory()->addItem($this->getItem());
    }

    public function removeSession(Session $session) : void{
        $session->getPlayer()->getInventory()->setItem(3, Item::get(0));
    }

    abstract public function getItem() : Item;

    abstract public function onInteract(PlayerInteractEvent $event) : void;
}