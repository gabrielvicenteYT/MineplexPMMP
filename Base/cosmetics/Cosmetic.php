<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use DinoVNOwO\Base\session\Session;
use dktapps\pmforms\MenuOption;

abstract class Cosmetic{

    private $id;
    private $type;

    public const PARTICLE = "particle";
    public const GADGET = "gadget";
    public const PETS = "pets";

    public function __construct(string $id, string $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getType() : string{
        return $this->type;
    }

    public function getId() : string{
        return $this->id;
    }

    abstract public function getMenuOption() : MenuOption;

    abstract public function addSession(Session $session) : void;

    abstract public function removeSession(Session $session) : void;
}