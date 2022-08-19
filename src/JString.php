<?php

namespace Recca0120\Lodash;

use Recca0120\Lodash\JString\Javascript;
use Recca0120\Lodash\JString\PHP;

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
        $this->subject = $subject === null ? '' : $subject;
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
     * @param mixed $object
     * @return bool
     */
    public static function supports($object)
    {
        return $object instanceof static || is_string($object) === true;
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
     * value.
     *
     * @return string
     */
    public function value()
    {
        return $this->subject;
    }
}
