<?php

namespace Test\LendInvest\ValueObject;

use LendInvest\Entity\Investor;
use LendInvest\ValueObject\Currency;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Investment;
use LendInvest\ValueObject\Money;
use PHPUnit\Framework\TestCase;

class InvestmentTest extends TestCase
{
    public function testCanCalculateInterestRate()
    {
        $currency = New Currency('GBP');
        $investor = new Investor('Investor 1', New Money(1000, $currency));

        $investment = new Investment($investor, New Money(1000, $currency), New \DateTimeImmutable('2015-10-03'));
        $investment->calculateInterest(new \DateTimeImmutable('2015-10-31'), new InterestRate(3));

        $expected = 1028.06;
        $this->assertEquals($expected, $investor->getBalance()->getAmount());

        $investor = new Investor('Investor 2', New Money(1000, $currency));
        $investment = new Investment($investor, New Money(500, $currency), New \DateTimeImmutable('2015-10-10'));
        $investment->calculateInterest(new \DateTimeImmutable('2015-10-31'), new InterestRate(6));

        $expected = 1021.29;
        $this->assertEquals($expected, $investor->getBalance()->getAmount());

        $investor = new Investor('Investor 2', New Money(1000, $currency));
        $investment = new Investment($investor, New Money(500, $currency), New \DateTimeImmutable('2015-09-10'));
        $investment->calculateInterest(new \DateTimeImmutable('2015-10-29'), new InterestRate(6));

        $expected = 1030;
        $this->assertEquals($expected, $investor->getBalance()->getAmount());
    }
}
