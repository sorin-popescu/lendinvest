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
     * @param int $days
     * @return float
     */
    public function getDailyRate(int $days): float
    {
        return $this->rate / 100 / $days;
    }
}
