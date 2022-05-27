<?php

namespace TestDataBuilder;

use PHPUnit\Framework\Constraint\Constraint;

class SimpleEqualsConstraint extends Constraint
{

    private $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
        parent::__construct();
    }

    protected function matches($other): bool
    {
        return $this->expected == $other;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf(
            'equals (==) %s',
            $this->exporter->export($this->expected)
        );
    }
}
