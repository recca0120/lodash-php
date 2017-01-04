<?php

namespace Recca0120\LoDash\Str;

trait Javascript
{
    public static function fromCharCode()
    {
        return new static(implode('', array_map('chr', func_get_args())));
    }

    public static function fromCodePoint()
    {
    }

    // Returns the character at the specified index (position)
    public function charAt($index = 0)
    {
        return ($this->length() > $index) ? $this->substr($index, 1) : '';
    }

    // Returns the Unicode of the character at the specified index
    public function charCodeAt($index = 0)
    {
        return ord($this->charAt($index));
    }

    // Joins two or more strings, and returns a new joined strings
    public function concat()
    {
        return new static(implode('', array_merge([$this->subject], func_get_args())));
    }

    // Checks whether a string ends with specified string/characters
    public function endsWith($searchString, $position = null)
    {
        $length = $this->length();
        $position = is_null($position) === true || $position > $length ? $length : $position;
        $position -= strlen($searchString);
        $lastIndex = $this->lastIndexOf($searchString, $position);

        return $lastIndex !== -1 && $lastIndex === $position;
    }

    // Checks whether a string contains the specified string/characters
    public function includes($searchString, $position = 0)
    {
        if ($position + strlen($searchString) > $this->length()) {
            return false;
        }

        return $this->indexOf($searchString, $position) !== -1;
    }

    // Returns the position of the first found occurrence of a specified value in a string
    public function indexOf($searchValue, $fromIndex = 0)
    {
        if (empty($searchValue) === true) {
            return $fromIndex;
        }

        $result = strpos($this->subject, $searchValue, $fromIndex);

        return $result === false ? -1 : $result;
    }

    // Returns the position of the last found occurrence of a specified value in a string
    public function lastIndexOf($searchValue, $fromIndex = null)
    {
        if (empty($searchValue) === true) {
            return is_null($fromIndex) === true ? $this->length() : $fromIndex;
        }

        if ($fromIndex === 0 || $fromIndex < 0) {
            return strrpos($this->subject, $searchValue, $fromIndex) !== 0 ? -1 : 0;
        }

        $fromIndex = is_null($fromIndex) === true ? 0 : $fromIndex;
        $result = strrpos($this->subject, $searchValue, $fromIndex);

        return $result === false ? -1 : $result;
    }

    // Compares two strings in the current locale
    public function localeCompare()
    {
    }

    // Searches a string for a match against a regular expression, and returns the matches
    public function match($regexp, $flag = PREG_PATTERN_ORDER, $offset = 0)
    {
        if ((bool) preg_match_all($regexp, $this->subject, $matches, $flag, $offset) === false) {
            return;
        }

        return $matches;
    }

    public function padEnd($length, $char = ' ')
    {
        return $this->pad($length, $char, STR_PAD_RIGHT);
    }

    public function padStart($length, $char = ' ')
    {
        return $this->pad($length, $char, STR_PAD_LEFT);
    }

    // Returns a new string with a specified number of copies of an existing string
    public function repeat($count)
    {
        return new static(str_repeat($this->subject, $count));
    }

    // Searches a string for a specified value, or a regular expression, and returns a new string where the specified values are replaced
    public function replace($regexp, $replacement = null)
    {
        if (is_array($regexp) === true && is_null($replacement) === true) {
            return new static(strtr($this->subject, $regexp));
        }

        if (is_callable($replacement) === true) {
            return new static(preg_replace_callback($regexp, $replacement, $this->subject));
        }

        return new static(preg_replace($regexp, $replacement, $this->subject));
    }

    // Searches a string for a specified value, or regular expression, and returns the position of the match
    public function search($regexp)
    {
        if ((bool) preg_match($regexp, $this->subject, $match, PREG_OFFSET_CAPTURE) === false) {
            return -1;
        }

        return $match[0][1];
    }

    // Extracts a part of a string and returns a new string
    public function slice($startSlice, $endSlice = null)
    {
        $length = $this->length();
        $startSlice = $startSlice < 0 ? $length + $startSlice : $startSlice;

        if (is_null($endSlice) === true) {
            return $this->substr($startSlice, $length - $startSlice);
        }

        $endSlice = $endSlice < 0 ? $length + $endSlice : $endSlice;
        $endSlice -= $startSlice;

        return $this->substr($startSlice, $endSlice);
    }

    // Splits a string into an array of substrings
    public function split($separator = null)
    {
        if (is_null($separator) === true) {
            return [$this->subject];
        }

        return explode($separator, $this->subject);
    }

    // Checks whether a string begins with specified characters
    public function startsWith($searchString, $position = 0)
    {
        return $this->substr($position, strlen($searchString))->value() === $searchString;
    }

    // Extracts the characters from a string, beginning at a specified start position, and through the specified number of character
    public function substr()
    {
        $result = call_user_func_array('substr', array_merge([$this->subject], func_get_args()));
        $result = $result === false ? '' : $result;

        return new static($result);
    }

    // Extracts the characters from a string, between two specified indices
    public function substring($indexStart, $indexEnd = null)
    {
        if (is_null($indexEnd) === true) {
            $indexEnd = $this->length();
        }

        $temp = [$indexStart, $indexEnd];
        sort($temp);

        return $this->slice($temp[0], $temp[1]);
    }

    // Converts a string to lowercase letters, according to the host's locale
    public function toLocaleLowerCase()
    {
    }

    // Converts a string to uppercase letters, according to the host's locale
    public function toLocaleUpperCase()
    {
    }

    // Converts a string to lowercase letters
    public function toLowerCase()
    {
        return new static(strtolower($this->subject));
    }

    // Converts a string to uppercase letters
    public function toUpperCase()
    {
        return new static(strtoupper($this->subject));
    }

    // Removes whitespace from both ends of a string
    public function trim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(trim($this->subject, $characterMask));
    }

    public function trimLeft($characterMask = " \t\n\r\0\x0B")
    {
        return $this->ltrim($characterMask);
    }

    public function trimRight($characterMask = " \t\n\r\0\x0B")
    {
        return $this->rtrim($characterMask);
    }

    // Returns the primitive value of a String object
    public function valueOf()
    {
        return $this->subject;
    }

    public function length()
    {
        return strlen($this->subject);
    }
}
