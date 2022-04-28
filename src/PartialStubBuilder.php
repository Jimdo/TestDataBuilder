<?php

namespace TestDataBuilder;

use PHPUnit\Framework\MockObject\MockObject;

class PartialStubBuilder extends StubBuilder
{
    /**
     * @var array
     */
    protected $arguments = [];
    /**
     * @param array $arguments
     * @return PartialStubBuilder
     */
    public function withConstructorArgs(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @param integer $index
     * @param mixed $argument
     * @return PartialStubBuilder
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
        $a = $this->testCase
            ->getMockBuilder($this->className)
            ->setConstructorArgs($this->arguments)
            ->setMethods(array_keys($this->fields));

        if (empty($this->arguments)) {
            $a->disableOriginalConstructor();
        }

        return $a->getMock();
    }
}
