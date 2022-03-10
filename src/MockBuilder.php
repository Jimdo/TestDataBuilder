<?php

namespace TestDataBuilder;

use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TestDataBuilder\MockBuilder\Expectation;

class MockBuilder extends StubBuilder
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
     * @var Expectation[]
     */
    protected $expectations;

    /**
     * @param string $className
     * @param TestCase $testCase
     */
    public function __construct($className, TestCase $testCase)
    {
        $this->className = $className;
        $this->testCase = $testCase;
        $this->expectations = array();
    }

    /**
     * @return MockBuilder
     */
    public function but()
    {
        return parent::but();
    }

    /**
     * @param string $method
     * @param mixed $will
     * @return MockBuilder
     */
    public function with($method, $will)
    {
        $with = $this->expects($method, $this->testCase->any());
        $with->will($will);
        return $this;
    }

    public function expectsCall($method)
    {
        return $this->expects($method, $this->testCase->once());
    }

    public function expectsNoCall($method)
    {
        return $this->expects($method, $this->testCase->never());
    }

    public function expectsCallAt($index, $method)
    {
        return $this->expects($method, $this->testCase->at($index));
    }

    public function expectsAtLeastOneCall($method)
    {
        return $this->expects($method, $this->testCase->atLeastOnce());
    }

    public function expectsExactNumberOfCalls($number, $method)
    {
        return $this->expects($method, $this->testCase->exactly($number));
    }

    /**
     * @return MockObject
     */
    public function build()
    {
        $mock = $this->createMock();
        $this->loadMethodMocks($mock);
        return $mock;
    }

    protected function createMock()
    {
        return $this->testCase->getMock($this->className, array(), array(), '', false, false);
    }

    private function loadMethodMocks($mock)
    {
        foreach ($this->expectations as $expectation) {
            $invocationMocker = $mock->expects($expectation->getInvocationMatcher());
            $methodConstraint = new SimpleEqualsConstraint($expectation->getMethod());
            $invocationMocker = $invocationMocker->method($methodConstraint);
            $invocationMockerReflection = new \ReflectionMethod(InvocationMocker::class, 'with');
            $invocationMockerReflection->invokeArgs(
                $invocationMocker,
                $this->buildIfValuesAreBuilder($expectation->getArguments())
            );
            if ($expectation->isStubbed()) {
                $invocationMocker->will($this->buildStub($expectation->getStub()));
            }
        }
    }

    private function expects($method, $invocationMatcher)
    {
        $expectation = new Expectation(
            $method,
            $invocationMatcher
        );
        if (isset($this->expectations[$method])) {
            $existingExpectation = $this->expectations[$method];
            if ($existingExpectation->isStubbed()) {
                $expectation->will($this->buildStub($existingExpectation->getStub()));
            }
        }
        $this->expectations[$method] = $expectation;
        return $expectation;
    }
}
