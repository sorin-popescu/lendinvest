<?php

namespace LendInvest\Aggregate;

use LendInvest\Entity\Investor;
use LendInvest\Entity\Tranche;
use LendInvest\Helper\TrancheList;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;
use DateTimeImmutable;
use RuntimeException;
use InvalidArgumentException;

class Loan
{
    /**
     * @var DateTimeImmutable
     */
    private $startDate;

    /**
     * @var DateTimeImmutable
     */
    private $endDate;

    /**
     * @var TrancheList
     */
    public $tranches;

    /**
     * Loan constructor.
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $endDate
     */
    public function __construct(DateTimeImmutable $startDate, DateTimeImmutable $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tranches = new TrancheList();
    }

    /**
     * @param Tranche $tranche
     */
    public function addTranche(Tranche $tranche)
    {
        $this->tranches->add($tranche);
    }

    /**
     * @param TrancheId $trancheId
     * @param Investor $investor
     * @param Money $amount
     * @param DateTimeImmutable $date
     * @return bool
     */
    public function invest(TrancheId $trancheId, Investor $investor, Money $amount, DateTimeImmutable $date)
    {
        if ($this->isClosed($date)) {
            throw new RuntimeException("Loan is closed.");
        }

        if ($this->tranches->doesNotHave($trancheId)) {
            throw new InvalidArgumentException("Tranche doesn't exist.");
        }

        $this->tranches->getTranche($trancheId)->addInvestment($amount, $investor, $date);

        return true;
    }

    public function calculateInterest(DateTimeImmutable $date)
    {
        if ($this->isClosed($date)) {
            throw new RuntimeException("Loan is closed.");
        }

        /** @var Tranche $tranche */
        foreach ($this->tranches->getTranches() as $tranche) {
            $tranche->calculateInterest($date);
        }
    }

    /**
     * @param DateTimeImmutable $date
     * @return bool
     */
    public function isClosed(DateTimeImmutable $date): bool
    {
        return $date->getTimestamp() < $this->startDate->getTimestamp()
            || $date->getTimestamp() > $this->endDate->getTimestamp();
    }
}
