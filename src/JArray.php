<?php

namespace Recca0120\Lodash;

use ArrayObject;
use Recca0120\Lodash\JArray\Javascript;

class JArray extends ArrayObject
{
    use Javascript;

    /**
     * factory.
     * @param array $subject
     * @return static
     */
    public static function factory($subject = [])
    {
        return new static((array) $subject);
    }

    /**
     * supports.
     * @param mixed $object
     * @return bool
     */
    public static function supports($object)
    {
        return $object instanceof static || is_array($object) === true;
    }

    /**
     * value.
     *
     * @return array
     */
    public function value()
    {
        return $this->subject;
    }
}
