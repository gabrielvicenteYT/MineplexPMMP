<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\events\currency;

use DinoVNOwO\Base\currency\Currency;
use DinoVNOwO\Base\events\SessionEvent;
use DinoVNOwO\Base\session\Session;

class CurrencyChangeEvent extends SessionEvent
{

    /**
     * @var Currency
     */
    private $currency;
    /**
     * @var int
     */
    private $amount;
                          
    public function __construct(Session $session, Currency $currency, int $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
        parent::__construct($session);
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}