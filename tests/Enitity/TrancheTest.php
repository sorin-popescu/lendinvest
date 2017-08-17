<?php
//
//namespace Test\LendInvest\Entity;
//
//use LendInvest\Entity\Tranche;
//use PHPUnit\Framework\TestCase;
//
//class TrancheTest extends TestCase
//{
//    public function testCanAddInvestmentWhenTheMaximumAmountHasntBeenReached()
//    {
//        $currency = new Currency('GBP');
//        $amount = new Money(1000, $currency);
//        $interestRate = new InterestRate(3);
//        $trancheId = new TrancheId('A');
//
//        $tranche = new Tranche($trancheId, $interestRate, $amount);
//
//        $this->assertTrue($tranche->hasReachedMaximumAmountToInvest());
//    }
//
//
//    public function testTrancheHasExceededMaximumAmount()
//    {
//        $startDate = new DateTimeImmutable('2017-01-01');
//        $investmentDate = new DateTimeImmutable('2017-05-01');
//        $endDate = new DateTimeImmutable('2018-01-01');
//        $loan = new Loan($startDate, $endDate);
//
//        $currency = new Currency('GBP');
//        $amount = new Money(1000, $currency);
//        $interestRate = new InterestRate(3);
//        $trancheId = new TrancheId('A');
//
//        $tranche = new Tranche($trancheId, $interestRate, $amount);
//        $loan->addTranche($tranche);
//        $loan->invest($trancheId, $amount, $investmentDate);
//        $this->expectException(RuntimeException::class);
//        $loan->invest($trancheId, $amount, $investmentDate);
//    }
//
//    public function testTrancheCanHaveMultipleInvestments()
//    {
//        $startDate = new DateTimeImmutable('2017-01-01');
//        $investmentDate = new DateTimeImmutable('2017-05-01');
//        $endDate = new DateTimeImmutable('2018-01-01');
//        $loan = new Loan($startDate, $endDate);
//
//        $currency = new Currency('GBP');
//        $investmentAmount = new Money(100, $currency);
//        $amount = new Money(1000, $currency);
//        $interestRate = new InterestRate(3);
//        $trancheId = new TrancheId('A');
//
//        $tranche = new Tranche($trancheId, $interestRate, $amount);
//        $loan->addTranche($tranche);
//        $loan->invest($trancheId, $investmentAmount, $investmentDate);
//        $loan->invest($trancheId, $investmentAmount, $investmentDate);
//
//        $this->assertFalse($tranche->hasReachedMaximumAmountToInvest());
//    }
//
//    public function testInvalidTranche()
//    {
//        $this->expectException(InvalidArgumentException::class);
//
//        $startDate = new DateTimeImmutable('2017-01-01');
//        $investmentDate = new DateTimeImmutable('2017-05-01');
//        $endDate = new DateTimeImmutable('2018-01-01');
//        $loan = new Loan($startDate, $endDate);
//        $currency = new Currency('GBP');
//        $amount = new Money(1000, $currency);
//        $trancheId = new TrancheId('A');
//
//        $loan->invest($trancheId, $amount, $investmentDate);
//    }
//}
