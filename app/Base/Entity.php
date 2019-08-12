<?php

namespace App\Base;

use Closure;
use ArrayAccess;

class Entity implements ArrayAccess
{
    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * 抛出属性
     *
     * @return array
     */
    protected function exportProperty()
    {
        return [];
    }

    /**
     * 转数组
     *
     * @return array
     */
    public function toArray()
    {
        $toArray = [];
        foreach ($this->exportProperty() as $property => $value) {
            if ($value instanceof Closure) {
                $value = $value($this);
            }
            $toArray[$property] = $value;
        }
        return $toArray;
    }
}
