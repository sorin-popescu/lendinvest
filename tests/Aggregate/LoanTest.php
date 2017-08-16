<?php

namespace Test\LendInvest\Aggregate;

use LendInvest\Aggregate\Loan;
use LendInvest\Entity\Tranche;
use LendInvest\ValueObject\Currency;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\Money;
use LendInvest\ValueObject\TrancheId;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    public function testCanAddTranche()
    {
        $startDate = new \DateTimeImmutable('2017-01-01');
        $endDate = new \DateTimeImmutable('2018-01-01');
        $loan = new Loan($startDate, $endDate);

        $currency = new Currency('GBP');
        $amount = new Money(1000, $currency);
        $interestRate = new InterestRate(3);
        $trancheId = new TrancheId('A');

        $tranche = new Tranche($trancheId, $interestRate, $amount);
        $loan->addTranche($tranche);
        $this->assertSame($tranche, $loan->getTranche(new TrancheId('A')));
    }

    public function testLoanIsOpen()
    {
        $startDate = new \DateTimeImmutable('2017-01-01');
        $endDate = new \DateTimeImmutable('2018-01-01');
        $now = new \DateTimeImmutable('2017-05-01');

        $loan = new Loan($startDate, $endDate);

        $this->assertTrue($loan->isOpened($now));
    }

    public function testDateIsPastLoanLife()
    {
        $startDate = new \DateTimeImmutable('2017-01-01');
        $endDate = new \DateTimeImmutable('2018-01-01');
        $now = new \DateTimeImmutable('2018-05-01');

        $loan = new Loan($startDate, $endDate);

        $this->assertfalse($loan->isOpened($now));
    }

    public function testDateIsBeforeLoanLife()
    {
        $startDate = new \DateTimeImmutable('2017-01-01');
        $endDate = new \DateTimeImmutable('2018-01-01');
        $now = new \DateTimeImmutable('2016-05-01');

        $loan = new Loan($startDate, $endDate);

        $this->assertfalse($loan->isOpened($now));
    }
}
