<?php

namespace Test\LendInvest\Aggregate;

use LendInvest\Aggregate\Loan;
use LendInvest\Entity\Investor;
use LendInvest\Entity\Tranche;
use LendInvest\ValueObject\Currency;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use InvalidArgumentException;
use DateTimeImmutable;

class LoanTest extends TestCase
{
    public function testYouCanNotInvestAfterEndDate()
    {
        $this->expectException(RuntimeException::class);

        $startDate = new DateTimeImmutable('2017-01-01');
        $investmentDate = new DateTimeImmutable('2019-05-01');
        $endDate = new DateTimeImmutable('2018-01-01');
        $loan = new Loan($startDate, $endDate);
        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $trancheId = new TrancheId('A');
        $investor = new Investor('Investor 1', $amount);

        $loan->addTranche(new Tranche($trancheId, new InterestRate(3), $amount));

        $loan->invest($trancheId, $investor, $amount, $investmentDate);
    }

    public function testYouCanNotInvestBeforeStartDate()
    {
        $this->expectException(RuntimeException::class);

        $startDate = new DateTimeImmutable('2017-01-01');
        $investmentDate = new DateTimeImmutable('2016-05-01');
        $endDate = new DateTimeImmutable('2018-01-01');

        $loan = new Loan($startDate, $endDate);
        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $trancheId = new TrancheId('A');
        $investor = new Investor('Investor 1', $amount);

        $loan->addTranche(new Tranche($trancheId, new InterestRate(3), $amount));

        $loan->invest($trancheId, $investor, $amount, $investmentDate);
    }

    public function testCanInvest()
    {
        $startDate = new DateTimeImmutable('2017-01-01');
        $investmentDate = new DateTimeImmutable('2017-05-01');
        $endDate = new DateTimeImmutable('2018-01-01');

        $loan = new Loan($startDate, $endDate);
        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $trancheId = new TrancheId('A');
        $investor = new Investor('Investor 1', $amount);

        $loan->addTranche(new Tranche($trancheId, new InterestRate(3), $amount));

        $result = $loan->invest($trancheId, $investor, $amount, $investmentDate);

        $this->assertTrue($result);
    }

    public function testInvalidTranche()
    {
        $this->expectException(InvalidArgumentException::class);

        $startDate = new DateTimeImmutable('2017-01-01');
        $investmentDate = new DateTimeImmutable('2017-05-01');
        $endDate = new DateTimeImmutable('2018-01-01');
        $loan = new Loan($startDate, $endDate);
        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $trancheId = new TrancheId('A');
        $investor = new Investor('Investor 1', $amount);

        $loan->invest($trancheId,$investor ,$amount, $investmentDate);
    }
}
