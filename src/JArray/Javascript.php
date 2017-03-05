<?php

namespace Recca0120\LoDash\JArray;

use Recca0120\LoDash\JString;

trait Javascript
{
    /**
     * The concat() method is used to merge two or more arrays.
     * This method does not change the existing arrays, but instead returns a new array.
     *
     * @return static
     */
    public function concat()
    {
        $array = $this->getArrayCopy();
        foreach (func_get_args() as $value) {
            $array = array_merge($array, (array) $value);
        }

        return new static($array);
    }

    /**
     * The copyWithin() method shallow copies part of an array to another location in the same array and returns it,
     * without modifying its size.
     *
     * @param  int $target
     * @param  int $start
     * @param  int $end
     * @return static
     */
    public function copyWithin($target, $start, $end)
    {
    }

    /**
     * The entries() method returns a new Array Iterator object that contains the key/value pairs for each index in the array.
     *
     * @return ArrayIterator
     */
    public function entries()
    {
        return $this->getIterator();
    }

    /**
     * The every() method tests whether all elements in the array pass the test implemented by the provided function.
     *
     * @param  callable $callback
     * @return bool
     */
    public function every(callable $callback)
    {
        $array = $this->getArrayCopy();
        foreach ($array as $key => $value) {
            if ($callback($value, $key, $array) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * The fill() method fills all the elements of an array from a start index to an end index with a static value.
     *
     * @param  $value
     * @param  $start
     * @param  $end
     * @return static
     */
    public function fill($value, $start = null, $end = null)
    {
        $array = $this->getArrayCopy();
        $length = $this->length();

        if ($end <= 0) {
            $end = $length - $end;
        }

        if (is_null($start) === true) {
            $i = $end ?: $length;

            while ($i--) {
                $array[$i] = $value;
            }
        }

        if ($start <= 0) {
            $start = $length - $start;
        }

        $end = $end ?: $length;
        $i = $start;

        while ($i !== $end) {
            $array[$i] = $value;
            ++$i;
        }

        return new static($array);
    }

    /**
     * The filter() method creates a new array with all elements that pass the test implemented by the provided function.
     *
     * @param  callable $callback
     * @return static
     */
    public function filter(callable $callback)
    {
        return new static(array_filter($this->getArrayCopy(), $callback));
    }

    /**
     * The find() method returns a value of the first element in the array that satisfies the provided testing function. Otherwise undefined is returned.
     *
     * @param  callable $callback
     * @return mix
     */
    public function find(callable $callback)
    {
        $array = $this->getArrayCopy();
        foreach ($array as $key => $value) {
            if ($callback($value, $key, $array) === true) {
                return $value;
            }
        }
    }

    /**
     * The findIndex() method returns an index of the first element in the array that satisfies the provided testing function.
     * Otherwise -1 is returned.
     *
     * @param  callable $callback
     * @return int|string
     */
    public function findIndex(callable $callback)
    {
        $array = $this->getArrayCopy();
        foreach ($array as $key => $value) {
            if ($callback($value, $key, $array) === true) {
                return $key;
            }
        }

        return -1;
    }

    /**
     * The forEach() method executes a provided function once for each array element.
     * php < 7 not allow forEach.
     *
     * @param  callable $callback
     */
    public function each(callable $callback)
    {
        $array = $this->getArrayCopy();
        foreach ($array as $key => $value) {
            $callback($value, $key, $array);
        }
    }

    /**
     * The includes() method determines whether an array includes a certain element, returning true or false as appropriate.
     *
     * @param  mix  $searchElement
     * @param  int $fromIndex
     * @return bool
     */
    public function includes($searchElement, $fromIndex = 0)
    {
        return in_array($searchElement, $this->slice($fromIndex)->getArrayCopy(), true);
    }

    /**
     * The indexOf() method returns the first index at which a given element can be found in the array, or -1 if it is not present.
     *
     * @param  mix  $searchElement
     * @param  int $fromIndex
     * @return int|string
     */
    public function indexOf($searchElement, $fromIndex = 0)
    {
        $result = array_search($searchElement, $this->getArrayCopy(), true);

        return $result === false ? -1 : $result + $fromIndex;

        // if ($fromIndex < 0) {
        //     $fromIndex = $this->length() + $fromIndex;
        // }
        // $result = array_search($searchElement, $this->slice($fromIndex)->getArrayCopy(), true);

        // return $result === false ? -1 : $result + $fromIndex;
    }

    /**
     * The join() method joins all elements of an array into a string.
     *
     * @param  string $separator [description]
     * @return \Recca0120\LoDash\Str;
     */
    public function join($separator = ',')
    {
        return new JString(implode($separator, $this->getArrayCopy()));
    }

    /**
     * The keys() method returns a new Array Iterator that contains the keys for each index in the array.
     *
     * @return \ArrayIterator
     */
    public function keys()
    {
        return (new static(array_keys($this->getArrayCopy())))->entries();
    }

    /**
     * The lastIndexOf() method returns the last index at which a given element can be found in the array, or -1 if it is not present. The array is searched backwards, starting at fromIndex.
     *
     * @param  mix $searchElement
     * @param  int $fromIndex
     * @return int|string
     */
    public function lastIndexOf($searchElement, $fromIndex = 0)
    {
        $result = array_search($searchElement, array_reverse($this->getArrayCopy(), true));

        return $result === false ? -1 : $result;
        // $result = array_search($searchElement, array_reverse($this->slice($fromIndex)->getArrayCopy(), true));

        // return ($result === false) ? -1 : $result + $fromIndex;
    }

    /**
     * The map() method creates a new array with the results of calling a provided function on every element in this array.
     *
     * @param  callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->getArrayCopy()));
    }

    /**
     * The pop() method removes the last element from an array and returns that element. This method changes the length of the array.
     *
     * @return static
     */
    public function pop()
    {
        $array = $this->getArrayCopy();
        $pop = array_pop($array);
        $this->exchangeArray($array);

        return $pop;
    }

    /**
     * The push() method adds one or more elements to the end of an array and returns the new length of the array.
     *
     * @return int
     */
    public function push()
    {
        $array = $this->getArrayCopy();
        foreach (func_get_args() as $parameter) {
            array_push($array, $parameter);
        }
        $this->exchangeArray($array);

        return $this->count();
    }

    /**
     * The reduce() method applies a function against an accumulator and each value of the array (from left-to-right) to reduce it to a single value.
     *
     * @param  callable $callback
     * @param  mix   $initialValue
     * @return mix
     */
    public function reduce(callable $callback, $initialValue = null)
    {
        return array_reduce($this->getArrayCopy(), $callback, $initialValue);
    }

    /**
     * The reduceRight() method applies a function against an accumulator and each value of the array (from right-to-left) has to reduce it to a single value.
     *
     * @param  callable $callback
     * @param  mix $initialValue
     * @return mix
     */
    public function reduceRight(callable $callback, $initialValue = null)
    {
        return $this->reverse(true)->reduce($callback, $initialValue);
    }

    /**
     * The reverse() method reverses an array in place. The first array element becomes the last, and the last array element becomes the first.
     *
     * @param  bool $preservekeys
     * @return static
     */
    public function reverse($preservekeys = false)
    {
        $array = $this->getArrayCopy();
        $array = array_reverse($array, $preservekeys);
        $this->exchangeArray($array);

        return new static($array);
    }

    /**
     * The shift() method removes the first element from an array and returns that element. This method changes the length of the array.
     *
     * @return mix
     */
    public function shift()
    {
        $array = $this->getArrayCopy();
        $result = array_shift($array);
        $this->exchangeArray($array);

        return $result;
    }

    /**
     * The slice() method returns a shallow copy of a portion of an array
     * into a new array object selected from begin to end (end not included). The original array will not be modified.
     *
     * @param  int $begin
     * @param  int $end
     * @return static
     */
    public function slice($begin, $end = null)
    {
        $array = $this->getArrayCopy();
        $length = $this->length();
        $begin = $begin < 0 ? $length + $begin : $begin;

        if (is_null($end) === true) {
            return new static(array_slice($array, $begin, $length - $begin));
        }

        $end = $end < 0 ? $length + $end : $end;
        $end -= $begin;

        return new static(array_slice($array, $begin, $end));
    }

    /**
     * The some() method tests whether some element in the array passes the test implemented by the provided function.
     *
     * @param  callable $callback
     * @return bool
     */
    public function some(callable $callback)
    {
        $array = $this->getArrayCopy();
        foreach ($array as $key => $value) {
            if ($callback($value, $key, $array) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * The sort() method sorts the elements of an array in place and returns the array. The sort is not necessarily stable. The default sort order is according to string Unicode code points.
     *
     * @param  callable|null $compareFunction
     * @return static
     */
    public function sort(callable $compareFunction = null)
    {
        if (is_null($compareFunction) === true) {
            $compareFunction = function ($a, $b) {
                return $a > $b;
            };
        }
        $array = $this->getArrayCopy();
        usort($array, $compareFunction);
        $this->exchangeArray($array);

        return $this;
    }

    /**
     * The splice() method changes the content of an array by removing existing elements and/or adding new elements.
     *
     * @return static
     */
    public function splice()
    {
        $array = $this->getArrayCopy();
        call_user_func_array('array_splice', array_merge([&$array], func_get_args()));
        $this->exchangeArray($array);

        return $this;
    }

    public function toLocaleString()
    {
    }

    /**
     * The toString() method returns a string representing the specified array and its elements.
     *
     * @return string
     */
    public function toString()
    {
        return (string) $this->join(',');
    }

    /**
     * The toString() method returns a string representing the specified array and its elements.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * The unshift() method adds one or more elements to the beginning of an array and returns the new length of the array.
     *
     * @return static
     */
    public function unshift()
    {
        $array = $this->getArrayCopy();
        call_user_func_array('array_unshift', array_merge([&$array], func_get_args()));
        $this->exchangeArray($array);

        return $this;
    }

    /**
     * The values() method returns a new Array Iterator object that contains the values for each index in the array.
     *
     * @return \ArrayIterator
     */
    public function values()
    {
        return (new static(array_values($this->getArrayCopy())))->entries();
    }

    /**
     * length.
     *
     * @return int
     */
    public function length()
    {
        return $this->count();
    }
}
