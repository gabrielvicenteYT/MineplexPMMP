<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\forms;

use DinoVNOwO\Base\forms\forms\ParticlesForm;

class FormsManager
{
    /**
     * @var array
     */
    private $forms;

    public function init() : void{
        $this->addForm(new ParticlesForm());
    }

    public function getForm(string $id) : ?Form{
        return $this->forms[$id] ?? null;
    }

    private function addForm(Form $form) : void{
        $this->forms[$form->getId()] = $form;
    }
}