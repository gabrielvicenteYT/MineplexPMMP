<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\forms;

use DinoVNOwO\Base\session\Session;
use dktapps\pmforms\BaseForm;

abstract class Form
{

    abstract public function getId() : string;

    abstract public function getForm() : BaseForm;

    abstract public function getOptions() : array;

    public function send(Session $session) : void{
        $session->getPlayer()->sendForm($this->getForm());
    }
}