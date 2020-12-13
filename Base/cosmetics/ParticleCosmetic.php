<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\cosmetics;

use DinoVNOwO\Base\session\Session;

abstract class ParticleCosmetic extends Cosmetic
{

    private $shape;
    private $session = [];

    public function __construct(string $id, string $type)
    {
        $this->shape = $this->generateShape();
        parent::__construct($id, $type);
    }

    public function addSession(Session $session) : void{
        $this->session[spl_object_hash($session)] = $session;
    }

    public function removeSession(Session $session) : void{
        unset($this->session[spl_object_hash($session)]);
    }

    public function getSessions() : array{
        return $this->session;
    }

    public function getShape() : array{
        return $this->shape;
    }

    public function setShape(array $shape) : void{
        $this->shape = $shape;
    }

    abstract function generateShape() : array;

    public function sendParticle() : void{
        foreach($this->getSessions() as $session){
            if($session->getPlayer() === null || !$session->getPlayer()->isOnline()){
                $this->removeSession($session);
            }
        }
    }
}