<?php

namespace LendInvest\Helper;

use LendInvest\ValueObject\Investment;

class InvestmentList
{
    private $array;

    public function __construct()
    {
        $this->array = [];
    }

    public function add(Investment $investment)
    {
        $this->array[] = $investment;
    }

    public function getInvestments(): array
    {
        return $this->array;
    }
}
