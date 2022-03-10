<?php

namespace TestDataBuilder;

class PartialMockBuilderForAbstractClass extends PartialMockBuilder
{
    protected function createMock()
    {
        return $this->testCase->getMockForAbstractClass(
            $this->className,
            $this->constructorArgs,
            '',
            $this->useOriginalConstructor(),
            $this->useOriginalClone()
        );
    }
}
