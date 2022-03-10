<?php

namespace Test\TestDataBuilder;
 
abstract class AbstractTestClass
{
    public function __construct($requiredParameter)
    {

    }

    /**
     * @return string
     */
    public function getTestValue()
    {
        return 'blah blah';
    }

    /**
     * @return string
     */
    abstract public function getTestValue2();
}
