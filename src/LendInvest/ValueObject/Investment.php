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
        $interest = $this->getInterestToBePaid($date, $interestRate);

        $increase = $this->amount->addInterest($interest);

        $this->investor->deposit($increase);
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    private function getInterestToBePaid(\DateTimeImmutable $date, InterestRate $interestRate): float
    {
        $daysInTheMonth = $date->format('t');
        $investedDays = $date->diff($this->date)->format("%a");

        if ($daysInTheMonth > $investedDays) {
            return ($investedDays + 1) * $interestRate->getDailyRate($daysInTheMonth);
        }

        return $daysInTheMonth * $interestRate->getDailyRate($daysInTheMonth);
    }
}
