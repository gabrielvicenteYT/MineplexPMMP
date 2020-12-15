<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics\particles;

use DinoVNOwO\Base\cosmetics\ParticleCosmetic;
use dktapps\pmforms\MenuOption;
use pocketmine\level\particle\DustParticle;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

class FlawlessAura extends ParticleCosmetic
{
    private $counter = 0;

    public function getMenuOption(): MenuOption
    {
        return new MenuOption("flawless_aura", TextFormat::colorize("&l&6Flawless Aura"));
    }

    public function generateShape(): array
    {
        $vector3 = [];
        $base = 9 + (int)(((float)rand() / (float)getrandmax() * 8) - (8 / 2));
        $theta = 0;
        $interval = (2 * M_PI) / $base;
        for ($i = 0; $i < $base; $i++) {
            $thetaRolled = $this->rollover($theta, 0.03);
            $radii = 1.3 + ((float)rand() / (float)getrandmax() * 0.09);
            $x = ($radii * cos($thetaRolled));
            $z = ($radii * sin($thetaRolled));
            $y = sin($this->rollover(6.28 * (float)rand() / (float)getrandmax(), (float)rand() / (float)getrandmax() * 0.1)) * (float)rand() / (float)getrandmax() * 0.8;
            for ($h = 0.1; $h <= 1.3; $h += 0.15) {
                $vector3[$i][] = new Vector3($x, $y + $h, $z);
            }
            $theta += $interval;
        }
        return $vector3;
    }

    private function rollover(float $value, float $additive)
    {
        $value += $additive;
        if ($value >= 2 * M_PI) {
            $value -= 2 * M_PI;
        }
        return $value;
    }

    public function sendParticle(): void
    {
        parent::sendParticle();
        foreach ($this->getSessions() as $session) {
            foreach ($this->getShape() as $pillars){
                $color = $this->getColors()[mt_rand(0, count($this->getColors()) - 1)];
                foreach($pillars as $pos){
                    $session->getPlayer()->getLevel()->addParticle(new DustParticle($session->getPlayer()->add($pos), $color[0], $color[1], $color[2]));
                }
            }
        }
        $this->setShape($this->generateShape());
    }

    public function getColors() : array{
        return [
            [255, 102, 102],
            [255, 140, 102],
            [255, 179, 102],
            [255, 217, 102],
            [255, 255, 102],
            [217, 255, 102],
            [179, 255, 102],
            [140, 255, 102],
            [102, 255, 102],
            [102, 255, 140],
            [102, 255, 179],
            [102, 255, 217],
            [102, 255, 255],
            [102, 217, 255],
            [102, 179, 255],
            [102, 140, 255],
            [102, 102, 255],
            [140, 102, 255],
            [179, 102, 255],
            [217, 102, 255],
            [255, 102, 255],
            [255, 102, 217],
            [255, 102, 179],
            [255, 102, 140],
            [255, 102, 102]
        ];
    }
}