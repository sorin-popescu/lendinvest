<?php

namespace LendInvest\Entity;

use LendInvest\ValueObject\Money;
use RuntimeException;

class Investor
{
    private $name;

    private $amount;

    public function __construct(string $name, Money $amount)
    {
        $this->name = $name;
        $this->amount = $amount;
    }

    public function hasFunds(Money $amount): bool
    {
        return $this->amount->isMoreThan($amount) || $this->amount->isEqual($amount);
    }

    public function deposit(Money $amount)
    {
        $this->amount = $this->amount->add($amount);
    }

    public function deduct(Money $amount)
    {
        if (!$this->hasFunds($amount)) {
            throw new RuntimeException("Insufficient funds in your wallet.");
        }

        $this->amount = $this->amount->deduct($amount);
    }

    public function getBalance()
    {
        return $this->amount;
    }
}
