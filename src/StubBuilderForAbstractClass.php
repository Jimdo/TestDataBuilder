<?php

namespace TestDataBuilder;
 
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class StubBuilderForAbstractClass extends StubBuilder
{
    /**
     * @var array
     */
    protected $arguments = array();

    /**
     * @param array $arguments
     * @return StubBuilderForAbstractClass
     */
    public function withConstructorArgs(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @param integer $index
     * @param mixed $argument
     * @return StubBuilderForAbstractClass
     */
    public function withArgument($index, $argument)
    {
        $this->arguments[(int) $index] = $argument;
        return $this;
    }

    /**
     * @return MockObject
     */
    protected function createStub()
    {
        return $this->testCase->getMockForAbstractClass(
            $this->className, $this->arguments
        );
    }
}
