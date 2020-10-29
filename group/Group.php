<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\group;

class Group{

    protected $id;
    
    protected $name = "none";
    private $format = "";

    private $permissions = [];

    public function __construct(int $id, string $name, string $format, array $permissions){
        $this->id = $id;
        $this->name = $name;
        $this->format = $format;
        $this->permissions = $permissions;
    }

    /* Currently no data update function due to not finding any good use of them */

    public function getId() : int{
        return $this->id;
    }

    public function getName() : string{
        return $this->name;
    }

    public function getFormat() : string{
        return $this->format;
    }

    public function getPermissions() : array{
        return $this->permissions;
    }

    /* Level fix sad */

    public function addSpace(bool $appendfirst = true, bool $appendend = true) : string{
        $text = $this->getFormat();
        if($appendfirst){
            $text = " " . $text;
        }
        if($appendend){
            $text .= " ";
        }
        return $text;
    }
}