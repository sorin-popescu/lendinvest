<?php

namespace LendInvest\Entity;

use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;

class Tranche
{
    /**
     * @var TrancheId
     */
    private $identifier;

    /**
     * @var InterestRate
     */
    private $interestRate;

    /**
     * @var Money
     */
    private $amountToInvest;

    /**
     * @var Money
     */
    private $amountInvested;

    /**
     * Tranche constructor.
     * @param TrancheId $trancheId
     * @param InterestRate $interestRate
     * @param Money $amountToInvest
     */
    public function __construct(TrancheId $trancheId, InterestRate $interestRate, Money $amountToInvest)
    {
        $this->identifier = $trancheId;
        $this->interestRate = $interestRate;
        $this->amountToInvest = $amountToInvest;
        $this->amountInvested = new Money(0, $amountToInvest->getCurrency());
    }

    /**
     * @param Money $amount
     */
    public function addInvestment(Money $amount)
    {
        $this->amountInvested = $this->amountInvested->add($amount);
    }

    /**
     * @return bool
     */
    public function hasReachedMaximumAmountToInvest()
    {
         return $this->amountToInvest->isLessThan($this->amountInvested);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier->__toString();
    }
}
