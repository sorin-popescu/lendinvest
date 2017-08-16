<?php

namespace LendInvest\ValueObject;

use InvalidArgumentException;

class Money
{
    /** @var  float */
    private $amount;

    /** @var Currency */
    private $currency;

    /**
     * Money constructor.
     * @param float $amount
     * @param Currency $currency
     */
    public function __construct(float $amount, Currency $currency)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException();
        }
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Money $other
     * @return Money
     */
    public function add(Money $other)
    {
        if ($other->getCurrency()->isNot($this->getCurrency())) {
            throw new InvalidArgumentException('Cannot add because currencies do not match');
        }
        $amount = $this->amount + $other->getAmount();

        return $this->newMoney($amount);
    }

    /**
     * @param Money $other
     * @return Money
     */
    public function deduct(Money $other)
    {
        if ($other->getCurrency()->isNot($this->getCurrency())) {
            throw new InvalidArgumentException('Cannot add because currencies do not match');
        }
        $amount = $this->amount - $other->getAmount();

        return $this->newMoney($amount);
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function isMoreThan(Money $other): bool
    {
        return $this->compareWith($other) === 1;
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function isLessThan(Money $other): bool
    {
        return $this->compareWith($other) < 1;
    }

    /**
     * @param float $amount
     * @return Money
     */
    private function newMoney(float $amount): Money
    {
        return new static($amount, $this->currency);
    }

    /**
     * @param Money $other
     * @return int
     */
    private function compareWith(Money $other): int
    {
        if ($other->getCurrency()->isNot($this->getCurrency())) {
            throw new InvalidArgumentException('Cannot compare because currencies do not match');
        }
        return $this->getAmount() <=> $other->getAmount();
    }
}
