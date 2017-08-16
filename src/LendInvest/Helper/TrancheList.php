<?php

namespace LendInvest\Helper;

use LendInvest\Entity\Tranche;
use LendInvest\ValueObject\TrancheId;

class TrancheList
{
    private $array;

    public function __construct()
    {
        $this->array = [];
    }

    public function add(Tranche $tranche)
    {
        $this->array[$tranche->getIdentifier()] = $tranche;
    }

    public function getTranche(TrancheId $trancheId): Tranche
    {
        return $this->array[$trancheId->__toString()];
    }

    public function hasTranche(TrancheId $trancheId): bool
    {
        return array_key_exists($trancheId->__toString(), $this->array);
    }
}
