<?php

namespace Recca0120\LoDash;

use ArrayObject;
use Recca0120\LoDash\JArray\Javascript;

class JArray extends ArrayObject
{
    use Javascript;

    public function value()
    {
        return $this->subject;
    }

    public static function factory($subject = [])
    {
        return new static((array) $subject);
    }

    public static function supports($object)
    {
        if ($object instanceof static || is_array($object) === true) {
            return true;
        }

        return false;
    }
}
