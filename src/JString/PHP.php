<?php

namespace Recca0120\LoDash\JString;

use Recca0120\LoDash\JArray;
use Recca0120\LoDash\JString\Extensions\Chinese;
use Recca0120\LoDash\JString\Extensions\FullCase;
use Recca0120\LoDash\JString\Extensions\Converter;

trait PHP
{
    /**
     * Quote string with slashes in a C style.
     *
     * @param string $charlist
     * @return static
     */
    public function addcslashes($charlist)
    {
        return new static(addcslashes($this->subject, $charlist));
    }

    /**
     *  Quote string with slashes.
     *
     * @return static
     */
    public function addslashes()
    {
        return new static(addslashes($this->subject));
    }

    /**
     *  Convert binary data into hexadecimal representation.
     *
     * @return static
     */
    public function bin2hex()
    {
        return new static(bin2hex($this->subject));
    }

    public function convertEncoding($toEncoding)
    {
        return func_num_args() === 1 ?
            new static(mb_convert_encoding($this->subject, $toEncoding)) :
            new static(mb_convert_encoding($this->subject, $toEncoding, func_get_arg(0)));
    }

    public function convertTo($variant = 'zh-tw')
    {
        return new static(Converter::instance()->convertTo($this->subject, $variant));
    }

    public function chineseToNumber()
    {
        return (new Chinese($this->subject))->toNumber();
    }

    /**
     * Split a string by string.
     *
     * @param string $delimiter
     * @param int $limit
     * @return \Recca0120\LoDash\JArray
     */
    public function explode($delimiter)
    {
        return func_num_args() === 1 ?
            new JArray(explode($delimiter, $this->subject)) :
            new JArray(explode($delimiter, $this->subject, func_get_arg(1)));
    }

    /**
     * Convert all HTML entities to their applicable characters.
     *
     * @param int $flags
     * @return static
     */
    public function htmlEntityDecode()
    {
        return func_num_args() === 0 ?
            new static(html_entity_decode($this->subject)) :
            new static(html_entity_decode($this->subject, func_get_arg(0)));
    }

    /**
     * Convert all applicable characters to HTML entities.
     *
     * @param int $flags
     * @return static
     */
    public function htmlentities()
    {
        return func_num_args() === 0 ?
            new static(htmlentities($this->subject)) :
            new static(htmlentities($this->subject, func_get_arg(0)));
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @param int $flags
     * @return static
     */
    public function htmlspecialcharsDecode()
    {
        return func_num_args() === 0 ?
            new static(htmlspecialchars_decode($this->subject)) :
            new static(htmlspecialchars_decode($this->subject, func_get_arg(0)));
    }

    /**
     * Convert special characters to HTML entities.
     *
     * @param int $flags
     * @return static
     */
    public function htmlspecialchars()
    {
        return func_num_args() === 0 ?
            new static(htmlspecialchars($this->subject)) :
            new static(htmlspecialchars($this->subject, func_get_arg(0)));
    }

    /**
     * Make a string's first character lowercase.
     *
     * @return static
     */
    public function lcfirst()
    {
        return new static(lcfirst($this->subject));
    }

    /**
     * Strip whitespace (or other characters) from the beginning of a string.
     *
     * @param string $characterMask
     * @return static
     */
    public function ltrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(ltrim($this->subject, $characterMask));
    }

    /**
     * Calculate the md5 hash of a string.
     *
     * @param bool $rawOutput
     * @return static
     */
    public function md5($rawOutput = false)
    {
        return new static(md5($this->subject, $rawOutput));
    }

    /**
     * Inserts HTML line breaks before all newlines in a string.
     *
     * @param bool $isXHTML
     * @return static
     */
    public function nl2br($isXHTML = true)
    {
        return new static(nl2br($this->subject, $isXHTML));
    }

    /**
     * Parses the string into variables.
     *
     * @return \Recca0120\LoDash\JArray
     */
    public function parse()
    {
        $results = [];
        parse_str($this->subject, $results);

        return new JArray($results);
    }

    /**
     * Strip whitespace (or other characters) from the end of a string.
     *
     * @param string $characterMask
     * @return static
     */
    public function rtrim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(rtrim($this->subject, $characterMask));
    }

    /**
     * Calculate the sha1 hash of a string.
     *
     * @return static
     */
    public function sha1()
    {
        return new static(sha1($this->subject));
    }

    /**
     * Parses input from a string according to a format.
     *
     * @param string $format
     * @return \Recca0120\LoDash\JArray
     */
    public function sscanf($format)
    {
        return new JArray(sscanf($this->subject, $format));
    }

    /**
     * Pad a string to a certain length with another string.
     *
     * @param int $length
     * @param string $chars
     * @param int $type
     * @return static
     */
    public function pad($length = 0, $chars = ' ', $type = STR_PAD_BOTH)
    {
        return new static(str_pad($this->subject, $length, $chars, $type));
    }

    /**
     * Perform the rot13 transform on a string.
     *
     * @return static
     */
    public function rot13()
    {
        return new static(str_rot13($this->subject));
    }

    /**
     * Randomly shuffles a string.
     *
     * @return static
     */
    public function shuffle()
    {
        return new static(str_shuffle($this->subject));
    }

    /**
     * Strip HTML and PHP tags from a string.
     *
     * @param string $allowable_tags
     *
     * @return static
     */
    public function stripTags()
    {
        return func_num_args() === 0 ?
            new static(strip_tags($this->subject)) :
            new static(strip_tags($this->subject, func_get_arg(0)));
    }

    /**
     * Un-quote string quoted with addcslashes().
     *
     * @return static
     */
    public function stripcslashes()
    {
        return new static(stripcslashes($this->subject));
    }

    /**
     * Un-quotes a quoted string.
     *
     * @return static
     */
    public function stripslashes()
    {
        return new static(stripslashes($this->subject));
    }

    /**
     * Reverse a string.
     *
     * @return static
     */
    public function reverse()
    {
        return new static(strrev($this->subject));
    }

    public function toFullCase()
    {
        return new static((new FullCase($this->subject))->toFullCase());
    }

    public function toHalfCase()
    {
        return new static((new FullCase($this->subject))->toHalfCase());
    }

    /**
     * Make a string's first character uppercase.
     *
     * @return static
     */
    public function ucfirst()
    {
        return new static(ucfirst($this->subject));
    }

    /**
     * Uppercase the first character of each word in a string.
     *
     * @param string $delimiters
     *
     * @return static
     */
    public function ucwords($delimiters = " \t\r\n\f\v")
    {
        return new static(ucwords($this->subject, $delimiters));
    }

    /**
     * Wraps a string to a given number of characters.
     *
     * @param int $width
     * @param string $break
     * @param bool $cut
     *
     * @return static
     */
    public function wordwrap($width = 75, $break = "\n", $cut = false)
    {
        return new static(wordwrap($this->subject, $break, $cut));
    }
}
