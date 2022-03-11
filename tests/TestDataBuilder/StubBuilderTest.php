<?php

namespace Test\TestDataBuilder;

use PHPUnit\Framework\TestCase;
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

        $this->assertEquals('blah blah', $stub->getTestValue());
        $this->assertEquals('test return value', $stub->getTestValue2());
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

        $this->assertNull($value);
        $this->assertNull($value2);
    }

    /**
     * @test
     */
    public function itShouldAddReturnValueImplementationForDefinedMethods()
    {
        $builder = new StubBuilder(TestClass::class, $this);
        $builder->with('getTestValue', 'test return value');

        $this->assertEquals('test return value', $builder->build()->getTestValue());
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
