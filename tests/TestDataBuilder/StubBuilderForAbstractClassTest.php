<?php

namespace Test\TestDataBuilder;

use PHPUnit_Framework_TestCase as TestCase;
use TestDataBuilder\StubBuilderForAbstractClass;

/**
 * @covers StubBuilderForAbstractClass
 * @covers StubBuilder
 */
class StubBuilderForAbstractClassTest extends TestCase
{

    /**
     * @test
     */
    public function itShouldStubImplementationForAbstractMethods()
    {
        $builder = new StubBuilderForAbstractClass(AbstractTestClass::class, $this);
        $builder->withConstructorArgs(array(true));
        $stub = $builder->build();
        $value = $stub->getTestValue();
        $value2 = $stub->getTestValue2();

        $this->assertThat($value === 'blah blah' && $value2 === null, $this->isTrue());
    }

    /**
     * @test
     */
    public function itShouldAddNewImplementationForAbstractMethods()
    {
        $builder = new StubBuilderForAbstractClass(AbstractTestClass::class, $this);
        $builder->withConstructorArgs(array(true));
        $builder->with('getTestValue2', 'test return value');

        $this->assertThat($builder->build()->getTestValue2(), $this->equalTo('test return value'));
    }
}
