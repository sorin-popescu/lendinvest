<?php

namespace LendInvest\ValueObject;

use LendInvest\Entity\Investor;

class Investment
{
    private $investor;

    private $amount;

    private $date;

    public function __construct(Investor $investor, Money $amount, \DateTimeImmutable $date)
    {
        $this->investor = $investor;
        $this->amount = $amount;
        $this->date = $date;
    }

    public function calculateInterest(\DateTimeImmutable $date, InterestRate $interestRate)
    {
        $investedDays = $date->diff($this->date)->format("%a");

        return $investedDays * $interestRate->getDailyRate();
    }
}
