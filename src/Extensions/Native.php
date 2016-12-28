<?php

namespace Recca0120\String\Extensions;

trait Native
{
    public function trim()
    {
        return new static(trim($this->string));
    }

    public function toLowerCase()
    {
        return new static(strtolower($this->string));
    }

    public function toUpperCase()
    {
        return new static(strtoupper($this->string));
    }

    public function replace($pattern, $replacement = null)
    {
        if (is_array($pattern) === true && is_null($replacement) === true) {
            return new static(strtr($this->string, $pattern));
        }

        if (is_callable($replacement) === true) {
            return new static(preg_replace_callback($pattern, $replacement, $this->string));
        }

        return new static(preg_replace($pattern, $replacement, $this->string));
    }

    public function match($pattern, $flags = PREG_PATTERN_ORDER, $offset = 0)
    {
        if (! preg_match_all($pattern, $this->string, $matches, $flags, $offset)) {
            return false;
        }

        return $matches;
    }

    public function encoding()
    {
        return new static(call_user_func_array(
            'mb_convert_encoding',
            array_merge([$this->string], func_get_args())
        ));
    }

    public function length()
    {
        return strlen($this->string);
    }

    public function substr()
    {
        return new static(call_user_func_array(
            'substr',
            array_merge([$this->string], func_get_args())
        ));
    }

    public function explode()
    {
        return call_user_func_array(
            'explode',
            array_merge(func_get_args(), [$this->string])
        );
    }

    public function prepend($string)
    {
        return new static($string.$this->string);
    }

    public function append($string)
    {
        return new static($this->string.$string);
    }
}
