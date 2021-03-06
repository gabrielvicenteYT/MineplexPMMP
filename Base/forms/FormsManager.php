<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\forms;

use DinoVNOwO\Base\Manager;

class FormsManager extends Manager
{
    /**
     * @var array
     */
    private $forms;

    public function init() : void{
    }

    public function getForm(string $id) : ?Form{
        return $this->forms[$id] ?? null;
    }

    public function addForm(Form $form) : void{
        $this->forms[$form->getId()] = $form;
    }
}