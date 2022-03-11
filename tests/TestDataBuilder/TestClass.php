<?php

namespace Test\TestDataBuilder;

class TestClass
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
    public function getTestValue2()
    {
        return 'blub blub';
    }
}
