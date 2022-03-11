<?php

namespace Test\TestDataBuilder;

use PHPUnit_Framework_TestCase as TestCase;
use TestDataBuilder\ArrayBuilder;
use TestDataBuilder\Builder;

/**
 * @covers ArrayBuilder
 */
class ArrayBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnDefinedFields()
    {
        $array = new ArrayBuilder();
        $array->with('test', 'test value');
        $array['test2'] = 'test value 2';

        $this->assertThat(
            $array->build(), $this->equalTo(array('test' => 'test value', 'test2' => 'test value 2'))
        );
    }

    /**
     * @test
     */
    public function itShouldReturnIfOffsetExists()
    {
        $array = new ArrayBuilder();
        $array['test'] = 'test value';

        $this->assertThat(isset($array['test']), $this->isTrue());
    }

    /**
     * @test
     */
    public function itShouldReturnIfOffsetNotExists()
    {
        $array = new ArrayBuilder();

        $this->assertThat(isset($array['test']), $this->isFalse());
    }

    /**
     * @test
     */
    public function itShouldReturnDefinedOffset()
    {
        $array = new ArrayBuilder();
        $array['anyOffset'] = 'any value';

        $this->assertThat($array['anyOffset'], $this->equalTo('any value'));
    }

    /**
     * @test
     */
    public function itShouldBuildOtherBuilders()
    {
        $otherBuilder = $this->getMockBuilder(Builder::class)->getMockForAbstractClass();
        $otherBuilder->expects($this->once())->method('build');

        $array = new ArrayBuilder();
        $array['anyOffset'] = $otherBuilder;
        $array->build();
    }
}
