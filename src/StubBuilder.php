<?php

namespace TestDataBuilder;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_Stub as Stub;
use PHPUnit_Framework_TestCase as TestCase;

class StubBuilder extends CustomBuilder
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var TestCase
     */
    protected $testCase;

    /**
     * @param string $className
     * @param TestCase $testCase
     */
    public function __construct($className, TestCase $testCase)
    {
        $this->className = $className;
        $this->testCase = $testCase;
    }

    /**
     * @param string $method
     * @param mixed $will
     * @return StubBuilder
     */
    public function with($method, $will)
    {
        return parent::with($method, $will);
    }

    /**
     * @return MockObject
     */
    public function build()
    {
        $stub = $this->createStub();
        $this->loadMethodStubs($stub);
        return $stub;
    }

    /**
     * @return MockObject
     */
    protected function createStub()
    {
        return $this->testCase->getMock($this->className, array(), array(), '', false, false);
    }

    /**
     * @param MockObject $stub
     */
    protected function loadMethodStubs($stub)
    {
        foreach ($this->fields as $field => $will) {
            $will = $this->buildStub($will);

            $methodConstraint = new SimpleEqualsConstraint($field);

            $stub->expects($this->testCase->any())->method($methodConstraint)->will($will);
        }
    }

    protected function buildStub($will)
    {
        if (!is_object($will) || !($will instanceof Stub)) {
            $will = $this->testCase->returnValue($this->buildIfValueIsABuilder($will));
        }
        return $will;
    }
}
