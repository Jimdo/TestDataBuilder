<?php

namespace TestDataBuilder;

use PHPUnit_Framework_MockObject_MockObject as MockObject;

class PartialStubBuilder extends StubBuilderForAbstractClass
{
    /**
     * @return MockObject
     */
    protected function createStub()
    {
        if (empty($this->arguments)) {
            $callOriginalConstructor = false;
        } else {
            $callOriginalConstructor = true;
        }
        return $this->testCase->getMock(
            $this->className, array_keys($this->fields), $this->arguments, '', $callOriginalConstructor
        );
    }
}
