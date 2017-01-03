<?php

namespace Recca0120\Library\Extensions\Str;

trait Native
{
    public function trim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(trim($this->str, $characterMask));
    }

    public function ltrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(ltrim($this->str, $characterMask));
    }

    public function rtrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(rtrim($this->str, $characterMask));
    }

    public function toLowerCase()
    {
        return new static(strtolower($this->str));
    }

    public function toUpperCase()
    {
        return new static(strtoupper($this->str));
    }

    public function replace($pattern, $replacement = null)
    {
        if (is_array($pattern) === true && is_null($replacement) === true) {
            return new static(strtr($this->str, $pattern));
        }

        if (is_callable($replacement) === true) {
            return new static(preg_replace_callback($pattern, $replacement, $this->str));
        }

        return new static(preg_replace($pattern, $replacement, $this->str));
    }

    public function match($pattern, $flags = PREG_PATTERN_ORDER, $offset = 0)
    {
        if (!preg_match_all($pattern, $this->str, $matches, $flags, $offset)) {
            return false;
        }

        return $matches;
    }

    public function encoding()
    {
        return new static(call_user_func_array(
            'mb_convert_encoding',
            array_merge([$this->str], func_get_args())
        ));
    }

    public function length()
    {
        return strlen($this->str);
    }

    public function substr()
    {
        return new static(call_user_func_array(
            'substr',
            array_merge([$this->str], func_get_args())
        ));
    }

    public function explode()
    {
        return call_user_func_array(
            'explode',
            array_merge(func_get_args(), [$this->str])
        );
    }

    public function prepend($string)
    {
        return new static($string.$this->str);
    }

    public function append($string)
    {
        return new static($this->str.$string);
    }

    public function base64Encode()
    {
        return new static(base64_encode($this->str));
    }

    public function base64Decode()
    {
        return new static(base64_decode($this->str));
    }
}
