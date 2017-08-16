<?php

namespace LendInvest\Entity;

use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\TrancheId;

class Tranche
{
    private $identifier;

    private $interestRate;

    private $amountToInvest;

    private $amountInvested;

    public function __construct(TrancheId $trancheId, InterestRate $interestRate, float $amountToInvest)
    {
        $this->identifier = $trancheId;
        $this->interestRate = $interestRate;
        $this->amountToInvest = $amountToInvest;
        $this->amountInvested = 0;
    }

    public function getIdentifier()
    {
        return $this->identifier->__toString();
    }
}
