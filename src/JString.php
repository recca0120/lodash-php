<?php

namespace Recca0120\Lodash;

use Recca0120\Lodash\JString\PHP;
use Recca0120\Lodash\JString\Javascript;

class JString
{
    use Javascript;
    use PHP;

    /**
     * $subject.
     *
     * @var string
     */
    public $subject;

    /**
     * __construct.
     *
     * @param string $subject
     */
    public function __construct($subject = '')
    {
        $this->subject = $subject;
    }

    /**
     * value.
     *
     * @return string
     */
    public function value()
    {
        return $this->subject;
    }

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * factory.
     *
     * @param string $subject
     * @return static
     */
    public static function factory($subject = '')
    {
        return new static((string) $subject);
    }

    /**
     * supports.
     * @param  static|string $object
     * @return bool
     */
    public static function supports($object)
    {
        if ($object instanceof static || is_string($object) === true) {
            return true;
        }

        return false;
    }
}
