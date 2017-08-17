<?php

namespace LendInvest\Entity;

use LendInvest\Helper\InvestmentList;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Investment;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;
use RuntimeException;

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
     * @var InvestmentList
     */
    private $investments;

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
        $this->investments = new InvestmentList();
    }

    /**
     * @param Money $amount
     * @param Investor $investor
     * @param \DateTimeImmutable $date
     */
    public function addInvestment(Money $amount, Investor $investor, \DateTimeImmutable $date)
    {
        if ($this->amountToInvest->isLessThan($this->amountInvested) ||
            $this->amountToInvest->isEqual($this->amountInvested)) {
            throw new RuntimeException("The invested amount is greater than the total amount.");
        }

        $investor->deduct($amount);

        $this->amountInvested = $this->amountInvested->add($amount);
        $this->investments->add(new Investment($investor, $amount, $date));
    }

    public function calculateInterest(\DateTimeImmutable $date)
    {
        $lastDay = $date->modify('last day of last month');
        /** @var Investment $investment */
        foreach ($this->investments->getInvestments() as $investment) {
            if ($lastDay > $investment->getDate()) {
                $investment->calculateInterest($lastDay, $this->interestRate);
            }
        }
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier->__toString();
    }
}
