<?php

namespace Test\TestDataBuilder;

use PHPUnit_Framework_TestCase as TestCase;
use TestDataBuilder\CustomBuilder;

/**
 * @covers CustomBuilder
 */
class CustomBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldHaveFields()
    {
        $testDataBuilder = $this->createTestDataBuilder();
        $testDataBuilder->with('test', 'test value')->with('test2', 'test value 2');

        $this->assertThat(
            $testDataBuilder->build(),
            $this->equalTo(array('test' => 'test value', 'test2' => 'test value 2'))
        );
    }

    /**
     * @test
     */
    public function itShouldReturnCloneOfItself()
    {
        $testDataBuilder = $this->createTestDataBuilder();

        $this->assertThat(
            $testDataBuilder->but(),
            $this->logicalAnd(
                $this->logicalNot($this->identicalTo($testDataBuilder)),
                $this->equalTo($testDataBuilder)
            )
        );
    }

    /**
     * @return CustomBuilder
     */
    private function createTestDataBuilder()
    {
        $testDataBuilder = new TestCustomBuilder();
        return $testDataBuilder;
    }
}

class TestCustomBuilder extends CustomBuilder
{
    public function build()
    {
        return $this->fields;
    }
}
