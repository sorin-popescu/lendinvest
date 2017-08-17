<?php

namespace Test\LendInvest\Entity;

use LendInvest\Entity\Investor;
use LendInvest\Entity\Tranche;
use LendInvest\ValueObject\Currency;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;
use PHPUnit\Framework\TestCase;

class TrancheTest extends TestCase
{
    public function testCanNotAddInvestmentWhenTheMaximumAmountHasBeenReached()
    {
        $this->expectException(\RuntimeException::class);
        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $interestRate = new InterestRate(3);
        $trancheId = new TrancheId('A');
        $investor = new Investor('Investor 1', new Money(1500, $currency));

        $tranche = new Tranche($trancheId, $interestRate, $amount);
        $tranche->addInvestment($amount, $investor, new \DateTimeImmutable('2017-01-01'));
        $tranche->addInvestment(new Money(500, $currency), $investor, new \DateTimeImmutable('2017-01-02'));
    }
}
