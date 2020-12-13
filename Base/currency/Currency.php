<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\currency;

class Currency{

    /**
     * @var int
     */
    private $currency;

    public const COINS = "coins";
    public const GEMS = "gems";
    public const ELO = "elo";
    public const SHARDS = "shards";

    public function __construct(int $currency){
        $this->currency = $currency;
    }
    /**
     * @return int
     */
    public function getCurrency(): int
    {
        return $this->currency;
    }

    public function addCurrency(int $amount) : void{
        $this->currency += $amount;
    }

    public function removeCurrency(int $amount) : void{
        $this->currency -= $amount;
    }

    public function multiplyCurrency(int $amount) : void{
        $this->currency *= $amount;
    }

    public function divideCurrency(int $amount) : void{
        $this->currency /= $amount;
    }
}