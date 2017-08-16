<?php

namespace LendInvest\ValueObject;

class TrancheId
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
