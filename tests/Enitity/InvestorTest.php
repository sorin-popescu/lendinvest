<?php

namespace Test\LendInvest\Entity;

use LendInvest\Entity\Investor;
use LendInvest\ValueObject\Currency;
use LendInvest\ValueObject\Money;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class InvestorTest extends TestCase
{
    public function testHasFundsReturnsTrueWhenThereIsEnoughMoney()
    {
        $currency = new Currency('GBP');
        $investor = new Investor('Investor 1', new Money(100, $currency));

        $result = $investor->hasFunds(new Money(50, $currency));

        $this->assertTrue($result);
    }

    public function testHasFundsReturnsFalseWhenThereIsNotEnoughMoney()
    {
        $currency = new Currency('GBP');
        $investor = new Investor('Investor 1', new Money(100, $currency));

        $result = $investor->hasFunds(new Money(150, $currency));

        $this->assertFalse($result);
    }

    public function testInvestorCanMakeDeposit()
    {
        $currency = new Currency('GBP');
        $expected = new Money(250, $currency);
        $investor = new Investor('Investor 1', new Money(100, $currency));

        $investor->deposit(new Money(150, $currency));

        $result  = $investor->getBalance()->getAmount();
        $this->assertEquals($expected->getAmount(), $result);
    }

    public function testInvestorCanDeductMoneyIfSufficientBalance()
    {
        $currency = new Currency('GBP');
        $expected = new Money(50, $currency);
        $investor = new Investor('Investor 1', new Money(100, $currency));

        $investor->deduct(new Money(50, $currency));

        $result  = $investor->getBalance()->getAmount();
        $this->assertEquals($expected->getAmount(), $result);
    }

    public function testInvestorCanNotDeductMoneyIfInsufficientBalance()
    {
        $this->expectException(RuntimeException::class);

        $currency = new Currency('GBP');
        $investor = new Investor('Investor 1', new Money(100, $currency));

        $investor->deduct(new Money(150, $currency));
    }
}
