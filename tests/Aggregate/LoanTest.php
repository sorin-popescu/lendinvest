<?php

namespace Test\LendInvest\Aggregate;

use LendInvest\Aggregate\Loan;
use LendInvest\Entity\Tranche;
use LendInvest\ValueObject\InterestRate;
use LendInvest\ValueObject\TrancheId;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    public function testCanAddTranche()
    {
        $startDate = new \DateTimeImmutable('2017-01-01');
        $endDate = new \DateTimeImmutable('2018-01-01');
        $loan = new Loan($startDate, $endDate);

        $tranche = new Tranche(new TrancheId('A'), new InterestRate(3), 1000);

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
}
