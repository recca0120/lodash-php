<?php

namespace Recca0120\Library\String;

use Recca0120\Library\String\Extensions\Native;
use Recca0120\Library\String\Extensions\Chinese;
use Recca0120\Library\String\Extensions\FullCase;
use Recca0120\Library\String\Extensions\Converter;


class Str
{
    use Native;

    public $str;

    public function __construct($str = '')
    {
        $this->str = $str;
    }

    public function set($str)
    {
        $this->str = $str;

        return $this;
    }

    public function convertTo($variant = 'zh-tw')
    {
        return new static(Converter::instance()->convertTo($this->value(), $variant));
    }

    public function toHalfCase()
    {
        return new static((new FullCase($this->str))->toHalfCase());
    }

    public function toFullCase()
    {
        return new static((new FullCase($this->str))->toFullCase());
    }

    public function chineseToNumber()
    {
        return new static((new Chinese($this->str))->toNumber());
    }

    public function value()
    {
        return $this->str;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function make($str)
    {
        return new static($str);
    }
}
