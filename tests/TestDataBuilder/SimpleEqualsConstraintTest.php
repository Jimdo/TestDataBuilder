<?php

namespace Test\TestDataBuilder;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;
use TestDataBuilder\SimpleEqualsConstraint;

class SimpleEqualsConstraintTest extends TestCase
{

    /**
     * @test
     */
    public function itShouldActAsAPHPUnitConstraint()
    {
        $constraint = new SimpleEqualsConstraint('something');

        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    /**
     * @test
     */
    public function itShouldEvaluateToTrueIfTheEvaluatedStringIsTheSameAsTheExpected()
    {
        $theString = 'the string';

        $constraint = new SimpleEqualsConstraint($theString);

        $this->assertThat(
            $constraint->evaluate($theString, '', true),
            $this->isTrue()
        );
    }

    /**
     * @test
     */
    public function itShouldEvaluateToFalseIfTheEvaluatedStringIsNotTheSameAsTheExpected()
    {
        $constraint = new SimpleEqualsConstraint('a string');

        $this->assertThat(
            $constraint->evaluate('another string', '', true),
            $this->isFalse()
        );
    }

}
