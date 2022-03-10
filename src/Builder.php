<?php

namespace TestDataBuilder;

/**
 * implements the common builder interface
 */
abstract class Builder
{

    /**
     * @return Builder
     */
    public function but()
    {
        return clone $this;
    }

    /**
     * @return object
     */
    abstract public function build();

    /**
     * @param array $values
     * @return array
     */
    protected function buildIfValuesAreBuilder(array $values)
    {
        $checkedValues = array();
        foreach ($values as $key => $value) {
            $checkedValues[$key] = $this->buildIfValueIsABuilder($value);
        }
        return $checkedValues;
    }

    /**
     * @param mixed $value
     * @return mixed $value
     */
    protected function buildIfValueIsABuilder($value)
    {
        return self::buildIfPossible($value);
    }

    /**
     * @param Builder|mixed $value
     * @return mixed
     */
    public static function buildIfPossible($value)
    {
        if ($value instanceof Builder) {
            return $value->build();
        }
        return $value;
    }
}
