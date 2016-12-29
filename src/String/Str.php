<?php

namespace Recca0120\Library\String;

use Recca0120\Library\String\Extensions\Native;
use Recca0120\Library\String\Extensions\FullCase;
use Recca0120\Library\String\Extensions\Converter;
use Recca0120\Library\String\Extensions\ChineseNumber;

class Str
{
    use Native;
    use FullCase;
    use ChineseNumber;

    public $string;

    public function __construct($string = '')
    {
        $this->string = $string;
    }

    public function set($string)
    {
        $this->string = $string;

        return $this;
    }

    public function convertTo($variant = 'zh-tw')
    {
        return new static(Converter::instance()->convertTo($this->string, $variant));
    }

    public function value()
    {
        return $this->string;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function make($string)
    {
        return new static($string);
    }
}
