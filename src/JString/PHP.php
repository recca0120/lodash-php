<?php

namespace Recca0120\LoDash\JString;

use Recca0120\LoDash\JString\Extensions\Chinese;
use Recca0120\LoDash\JString\Extensions\FullCase;
use Recca0120\LoDash\JString\Extensions\Converter;

trait PHP
{
    public function convertEncoding()
    {
        return new static(call_user_func_array(
            'mb_convert_encoding',
            array_merge([$this->subject], func_get_args())
        ));
    }

    public function convertTo($variant = 'zh-tw')
    {
        return new static(Converter::instance()->convertTo($this->subject, $variant));
    }

    public function explode($separator)
    {
        return explode($separator, $this->subject);
    }

    public function ltrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(ltrim($this->subject, $characterMask));
    }

    public function rtrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(rtrim($this->subject, $characterMask));
    }

    public function pad($length = 0, $chars = ' ', $type = STR_PAD_BOTH)
    {
        return str_pad($this->subject, $length, $chars, $type);
    }

    public function toFullCase()
    {
        return new static((new FullCase($this->subject))->toFullCase());
    }

    public function toHalfCase()
    {
        return new static((new FullCase($this->subject))->toHalfCase());
    }

    public function chineseToNumber()
    {
        return (new Chinese($this->subject))->toNumber();
    }
}
