<?php

namespace LendInvest\Aggregate;

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
    private $tranches;

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

    public function invest(TrancheId $trancheId, Money $amount, DateTimeImmutable $date)
    {
        if (!$this->isOpened($date)) {
            throw new RuntimeException();
        }

        if (!$this->tranches->hasTranche($trancheId)) {
            throw new InvalidArgumentException()   ;
        }

        $tranche = $this->tranches->getTranche($trancheId);

        if ($tranche->hasReachedMaximumAmountToInvest()) {
            throw new RuntimeException();
        }

        $tranche->addInvestment($amount);
    }

    /**
     * @param DateTimeImmutable $date
     * @return bool
     */
    public function isOpened(DateTimeImmutable $date): bool
    {
        return $date > $this->startDate && $date < $this->endDate;
    }
}
