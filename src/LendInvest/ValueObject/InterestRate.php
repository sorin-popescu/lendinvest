<?php

namespace LendInvest\ValueObject;

class InterestRate
{
    /**
     * @var float
     */
    private $rate;


    public function __construct(float $rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getDailyRate(): float
    {
        return $this->rate / 100 * 12 / 365;
    }
}
