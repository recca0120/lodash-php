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
        if (!preg_match_all($pattern, $this->string, $matches, $flags, $offset)) {
            return false;
        }

        return $matches;
    }

    public function encoding($to, $from = null)
    {
        return new static(mb_convert_encoding(
            $this->string,
            $to,
            is_null($from) === true ? mb_internal_encoding() : $from
        ));
    }

    public function length()
    {
        return strlen($this->string);
    }
}
