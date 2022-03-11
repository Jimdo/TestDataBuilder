<?php

namespace Test\TestDataBuilder;

use PHPUnit_Framework_TestCase as TestCase;
use TestDataBuilder\Builder;
use TestDataBuilder\PartialStubBuilder;
use TestDataBuilder\StubBuilder;

/**
 * @covers StubBuilder
 * @covers StubBuilder
 */
class StubBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldStubImplementationForDefinedMethodsOnly()
    {
        $builder = new PartialStubBuilder(TestClass::class, $this);
        $builder->with('getTestValue2', 'test return value');
        $stub = $builder->build();

        $this->assertThat(
            $stub->getTestValue() === 'blah blah' && $stub->getTestValue2() === 'test return value', $this->isTrue()
        );
    }

    /**
     * @test
     */
    public function itShouldStubImplementationForAllMethodsAsDefault()
    {
        $builder = new StubBuilder(TestClass::class, $this);
        $stub = $builder->build();
        $value = $stub->getTestValue();
        $value2 = $stub->getTestValue2();

        $this->assertThat($value === null && $value2 === null, $this->isTrue());
    }

    /**
     * @test
     */
    public function itShouldAddReturnValueImplementationForDefinedMethods()
    {
        $builder = new StubBuilder(TestClass::class, $this);
        $builder->with('getTestValue', 'test return value');

        $this->assertThat($builder->build()->getTestValue(), $this->equalTo('test return value'));
    }

    /**
     * @test
     */
    public function itShouldAddThrowExceptionImplementationForDefinedMethods()
    {
        $this->expectException(\RuntimeException::class);
        $builder = new StubBuilder(TestClass::class, $this);
        $builder->with('getTestValue', $this->throwException(new \RuntimeException()));

        $builder->build()->getTestValue();
    }

    /**
     * @test
     */
    public function itShouldBuildOtherBuilders()
    {
        $otherBuilder = $this->getMockBuilder(Builder::class)->getMockForAbstractClass();
        $otherBuilder->expects($this->once())->method('build');

        $builder = new StubBuilder(TestClass::class, $this);
        $builder->with('getTestValue', $otherBuilder);
        $builder->build();
    }
}
