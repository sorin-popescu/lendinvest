<?php

namespace LendInvest\ValueObject;

class Currency
{
    private $code;

    /**
     * Currency constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @param Currency $other
     * @return bool
     */
    public function isNot(Currency $other): bool
    {
        return !$this->is($other);
    }

    /**
     * @param Currency $other
     * @return bool
     */
    public function is(Currency $other): bool
    {
        return $this->code === $other->code;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->code;
    }
}
