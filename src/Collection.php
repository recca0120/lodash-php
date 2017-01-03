<?php

namespace Recca0120\Library;

use ArrayObject;

class Collection extends ArrayObject
{
    public function countBy(callable $iteratee = null)
    {
        if (is_null($iteratee) === true) {
            $iteratee = function ($value) {
                return $value;
            };
        }

        $result = [];

        foreach ($this as $value) {
            $value = $iteratee($value);
            $result[$value] = isset($result[$value]) === true ? $result[$value] + 1 : 1;
        }

        return new static($result);
    }

    public function each(callable $iteratee)
    {
        $this->forEach($iteratee);
    }

    public function eachRight(callable $iteratee)
    {
        $this->foreachRight($iteratee);
    }

    public function every(callable $predicate)
    {
        foreach ($this as $key => $value) {
            if ($predicate($value, $key) === false) {
                return false;
            }
        }

        return true;
    }

    public function find(callable $predicate)
    {
        foreach ($this as $key => $value) {
            if ($predicate($value) === true) {
                return is_array($value) === true ? new static($value): $value;
            }
        }

        return null;
    }

    public function findLast(callable $predicate)
    {
        return $this->reverse()->find($predicate);
    }

    public function flatMap()
    {

    }

    public function flatMapDeep()
    {

    }

    public function flatMapDepth()
    {

    }

    public function forEach(callable $iteratee)
    {
        foreach ($this as $key => $value) {
            $iteratee($value, $key);
        }
    }

    public function foreachRight(callable $iteratee)
    {
        foreach ($this->reverse(true) as $key => $value) {
            $iteratee($value, $key);
        }
    }

    public function groupBy(callable $iteratee)
    {
        $results = [];

        foreach ($this as $value) {
            $key = $iteratee($value);

            $results[$key][] = $value;
        }

        return new static($results);
    }

    public function includes($value, $fromIndex = 0)
    {
        return in_array($value, array_slice($this->value(), $fromIndex)) === true;
    }

    public function invokeMap()
    {

    }

    public function keyBy($iteratee)
    {
        $results = [];

        if (is_callable($iteratee) === true) {
            foreach ($this as $value)
            {
                $results[$iteratee($value)] = $value;
            }
        } else {
            foreach ($this as $value)
            {
                $results[$value[$iteratee]] = $value;
            }
        }

        return new static($results);
    }

    public function map(callable $iteratee)
    {
        return new static(array_map($iteratee, $this->value()));
    }

    public function orderBy()
    {

    }

    public function partition()
    {

    }

    public function filter(callable $predicate, $flag = 0)
    {
        // ARRAY_FILTER_USE_KEY
        // ARRAY_FILTER_USE_BOTH
        return new static(array_filter($this->value(), $predicate, $flag));
    }

    public function reduce(callable $iteratee, $accumulator = null)
    {
        return array_reduce($this, $iteratee, $accumulator);
    }

    public function reverse($preserveKeys = false)
    {
        return new static(array_reverse($this->value()));
    }

    public function value()
    {
        return $this->getArrayCopy();
    }

    public static function be($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        if (is_array($value) === true) {
            return new static($value);
        }

        return false;
    }
}
