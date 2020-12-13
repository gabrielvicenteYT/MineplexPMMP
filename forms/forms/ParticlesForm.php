<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\forms\forms;

use DinoVNOwO\Base\cosmetics\Cosmetic;
use DinoVNOwO\Base\forms\Form;
use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\session\Session;
use DinoVNOwO\Base\utils\FormatContainer;
use dktapps\pmforms\BaseForm;
use dktapps\pmforms\MenuForm;
use pocketmine\utils\TextFormat;

class ParticlesForm extends Form
{

    public function getId(): string
    {
        return "particles_form";
    }

    public function getForm(): BaseForm
    {
        return new MenuForm(
            TextFormat::colorize("&l&aParticles"),
            "Select one of the category",
            $this->getOptions(),
            function(Session $session, int $selectedOption) : void{
                $option = $this->getOptions()[$selectedOption];
                $cosmetic = Initial::getCosmeticsManager()->getCosmetic(Cosmetic::PARTICLE, $option->getId());
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
        foreach(Initial::getCosmeticsManager()->getCosmeticGroup(Cosmetic::PARTICLE) as $item){
            $options[] = $item->getMenuOption();
        }
        return $options;
    }
}