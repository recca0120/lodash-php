<?php

namespace Recca0120\LoDash\Str;

trait Javascript
{
    /**
     * The static String.fromCharCode() method returns a string created by using the specified sequence of Unicode values.
     *
     * @return static
     */
    public static function fromCharCode()
    {
        return new static(implode('', array_map('chr', func_get_args())));
    }

    /**
     * The static String.fromCodePoint() method returns a string created by using the specified sequence of code points.
     *
     * @return static
     */
    public static function fromCodePoint()
    {
    }

    /**
     * The charAt() method returns the specified character from a string.
     *
     * @param  int $index
     *
     * @return static
     */
    public function charAt($index = 0)
    {
        return ($this->length() > $index) ? $this->substr($index, 1) : '';
    }

    /**
     * The charCodeAt() method returns an int between 0 and 65535
     * representing the UTF-16 code unit at the given index
     * (the UTF-16 code unit matches the Unicode code point for code points representable in a single UTF-16 code unit,
     * but might also be the first code unit of a surrogate pair for code points not representable in a single UTF-16 code unit,
     * e.g. Unicode code points > 0x10000). If you want the entire code point value, use codePointAt().
     *
     * @param  int $index
     *
     * @return int
     */
    public function charCodeAt($index = 0)
    {
        return ord($this->charAt($index));
    }

    /**
     * The codePointAt() method returns a non-negative int that is the Unicode code point value.
     *
     * @param  int $index
     *
     * @return int
     */
    public function codePointAt($index = 0)
    {
    }

    /**
     * The concat() method combines the text of one or more strings and returns a new string.
     *
     * @return static
     */
    public function concat()
    {
        return new static(implode('', array_merge([$this->subject], func_get_args())));
    }

    /**
     * The endsWith() method determines whether a string ends with the characters of another string,
     * returning true or false as appropriate.
     *
     * @param  string $searchString
     * @param  int $position
     *
     * @return bool
     */
    public function endsWith($searchString, $position = null)
    {
        $length = $this->length();
        $position = is_null($position) === true || $position > $length ? $length : $position;
        $position -= strlen($searchString);
        $lastIndex = $this->lastIndexOf($searchString, $position);

        return $lastIndex !== -1 && $lastIndex === $position;
    }

    /**
     * The includes() method determines whether one string may be found within another string,
     * returning true or false as appropriate.
     *
     * @param  string  $searchString
     * @param  int $position
     *
     * @return bool
     */
    public function includes($searchString, $position = 0)
    {
        if ($position + strlen($searchString) > $this->length()) {
            return false;
        }

        return $this->indexOf($searchString, $position) !== -1;
    }

    /**
     * The indexOf() method returns the index within the calling String object of the first occurrence of the specified value,
     * starting the search at fromIndex. Returns -1 if the value is not found.
     *
     * @param  string  $searchValue
     * @param  int $fromIndex
     *
     * @return int
     */
    public function indexOf($searchValue, $fromIndex = 0)
    {
        if (empty($searchValue) === true) {
            return $fromIndex;
        }

        $result = strpos($this->subject, $searchValue, $fromIndex);

        return $result === false ? -1 : $result;
    }

    /**
     * The lastIndexOf() method returns the index within the calling String object of the last occurrence of the specified value,
     * searching backwards from fromIndex. Returns -1 if the value is not found.
     *
     * @param  string $searchValue
     * @param  int $fromIndex
     *
     * @return int
     */
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

    /**
     * The localeCompare() method returns a number indicating
     * whether a reference string comes before or after or is the same as the given string in sort order.
     *
     * @return int
     */
    public function localeCompare()
    {
    }

    /**
     * The match() method retrieves the matches when matching a string against a regular expression.
     *
     * @param  string  $regexp
     * @param  int  $flag
     * @param  int $offset
     *
     * @return array
     */
    public function match($regexp, $flag = PREG_PATTERN_ORDER, $offset = 0)
    {
        if ((bool) preg_match_all($regexp, $this->subject, $matches, $flag, $offset) === false) {
            return;
        }

        return $matches;
    }

    /**
     * The padEnd() method pads the current string with a given string (possibly repeated)
     * so that the resulting string reaches a given length. The padding is applied from the end (right) of the current string.
     *
     * @param  int $targetLength
     * @param  string $padString
     *
     * @return static
     */
    public function padEnd($targetLength, $padString = ' ')
    {
        return $this->pad($targetLength, $padString, STR_PAD_RIGHT);
    }

    /**
     * The padStart() method pads the current string with a given string (eventually repeated)
     * so that the resulting string reaches a given length. The pad is applied from the start (left) of the current string.
     *
     * @param  int $targetLength
     * @param  string $padString
     *
     * @return static
     */
    public function padStart($targetLength, $padString = ' ')
    {
        return $this->pad($targetLength, $padString, STR_PAD_LEFT);
    }

    /**
     * The repeat() method constructs and returns a new string which contains the specified number of copies of the string on which it was called, concatenated together.
     *
     * @param  int $count
     *
     * @return static
     */
    public function repeat($count)
    {
        return new static(str_repeat($this->subject, $count));
    }

    /**
     * The replace() method returns a new string with some or all matches of a pattern replaced by a replacement. The pattern can be a string or a RegExp, and the replacement can be a string or a function to be called for each match.
     *
     * @param  string $regexp
     * @param  mix $replacement
     *
     * @return static
     */
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