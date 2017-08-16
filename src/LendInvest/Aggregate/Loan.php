<?php

namespace LendInvest\Aggregate;

use LendInvest\Entity\Tranche;
use LendInvest\Helper\TrancheList;
use LendInvest\ValueObject\TrancheId;

class Loan
{
    /**
     * @var \DateTimeImmutable
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * @var TrancheList
     */
    private $tranches;

    /**
     * Loan constructor.
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     */
    public function __construct(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
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

    public function getTranche(TrancheId $trancheId)
    {
        return $this->tranches->getTranche($trancheId);
    }
}
