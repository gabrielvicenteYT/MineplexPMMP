<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\group;

class Group{

    /* Also work like position id */
    protected $id;

    private $format = "";

    private $permissions = [];

    public function __construct(int $id, string $format, array $permissions){
        $this->id = $id;
        $this->format = $format;
        $this->permissions = $permissions;
    }

    /* Currently no data update function due to not finding any good use of them */

    public function getId() : int{
        return $this->id;
    }

    public function getFormat() : string{
        return $this->format;
    }

    public function getPermissions() : array{
        return $this->permissions;
    }
}