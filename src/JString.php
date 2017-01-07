<?php

namespace Recca0120\LoDash;

use Recca0120\LoDash\JString\PHP;
use Recca0120\LoDash\JString\Javascript;

class JString
{
    use Javascript;
    use PHP;

    public $subject;

    public function __construct($subject = '')
    {
        $this->subject = $subject;
    }

    public function value()
    {
        return $this->subject;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function factory($subject = '')
    {
        return new static((string) $subject);
    }

    public static function supports($object)
    {
        if ($object instanceof static || is_string($object) === true) {
            return true;
        }

        return false;
    }
}
