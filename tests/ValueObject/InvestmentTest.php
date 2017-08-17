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
        $investment = new Investment($investor, New Money(100, $currency), New \DateTimeImmutable('2017-02-01'));
        $result = $investment->calculateInterest(new \DateTimeImmutable('2017-03-01'), new InterestRate(3));
        $expected = 0.027616438356164;
        $this->assertEquals($expected, $result);
    }
}
