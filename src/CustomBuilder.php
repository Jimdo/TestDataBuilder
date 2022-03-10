<?php

namespace TestDataBuilder;

abstract class CustomBuilder extends Builder
{
    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @param string $field
     * @param mixed $value
     * @return CustomBuilder
     */
    public function with($field, $value)
    {
        $this->fields[$field] = $value;
        return $this;
    }
}
