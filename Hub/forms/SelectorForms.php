<?php


namespace DinoVNOwO\Hub\forms;

use DinoVNOwO\Base\forms\Form;
use DinoVNOwO\Base\session\Session;
use DinoVNOwO\Base\utils\FormatContainer;
use dktapps\pmforms\BaseForm;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;

class SelectorForms extends Form
{

    public function getId(): string
    {
        return "selector_form";
    }

    public function getForm(): BaseForm
    {
        return new MenuForm(
            FormatContainer::format(FormatContainer::PARTICLE_FORM_NAME),
            FormatContainer::format(FormatContainer::PARTICLE_FORM_LINE),
            $this->getOptions(),
            function(Session $session, int $selectedOption) : void{
            },
            function(Session $session) : void{
            }
        );
    }

    public function getOptions(): array
    {
        return [new MenuOption("skyblock", FormatContainer::format(FormatContainer::SKYBLOCK_SERVER_BUTTON_NAME, ["{online}","{max}"], [0,0]))];
    }
}