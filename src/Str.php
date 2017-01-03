<?php

namespace Recca0120\LoDash;

use Recca0120\LoDash\Str\PHP;
use Recca0120\LoDash\Str\Javascript;

class Str
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
        return new static($subject);
    }
}
