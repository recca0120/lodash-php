<?php

namespace Recca0120\Lodash;

use ArrayObject;
use Recca0120\Lodash\JArray\Javascript;

class JArray extends ArrayObject
{
    use Javascript;

    /**
     * value.
     *
     * @return array
     */
    public function value()
    {
        return $this->subject;
    }

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
     * @param  static|array $object
     * @return bool
     */
    public static function supports($object)
    {
        if ($object instanceof static || is_array($object) === true) {
            return true;
        }

        return false;
    }
}
