<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub\forms;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\forms\Form;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use DinoVNOwO\Base\utils\FormatContainer;
use DinoVNOwO\Hub\Hub;
use dktapps\pmforms\BaseForm;
use dktapps\pmforms\MenuForm;

class ParticlesForm extends Form
{

    public function getId(): string
    {
        return "particles_form";
    }

    public function getForm(): BaseForm
    {
        return new MenuForm(
            FormatContainer::format(FormatContainer::PARTICLE_FORM_NAME),
            FormatContainer::format(FormatContainer::PARTICLE_FORM_LINE),
            $this->getOptions(),
            function(Session $session, int $selectedOption) : void{
                $option = $this->getOptions()[$selectedOption];
                $cosmetic = Initial::getManager(Hub::COSMETICS)->getCosmetic(Cosmetic::PARTICLE, $option->getId());
                if($session->setActiveCosmetic(Cosmetic::PARTICLE, $option->getId())){
                    $session->getPlayer()->sendMessage(FormatContainer::format(FormatContainer::ACTIVE_PARTICLE_COSMETIC, ["{cosmetic_name}"], [$option->getText()]));
                }else{
                    $session->getPlayer()->sendMessage(FormatContainer::format(FormatContainer::DISABLE_PARTICLE_COSMETIC, ["{cosmetic_name}"], [$option->getText()]));
                }
            },
            function(Session $session) : void{

            }
        );
    }

    public function getOptions(): array
    {
        $options = [];
        foreach(Initial::getManager(Hub::COSMETICS)->getCosmeticGroup(Cosmetic::PARTICLE) as $item){
            $options[] = $item->getMenuOption();
        }
        return $options;
    }
}