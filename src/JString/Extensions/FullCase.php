<?php

namespace Recca0120\LoDash\JString\Extensions;

class FullCase
{
    /**
     * $fullCaseMap.
     *
     * @var array
     */
    public static $fullCaseMap = [
        '　' => ' ',
        '！' => '!',
        '＂' => '"',
        '＃' => '#',
        '＄' => '$',
        '％' => '%',
        '＆' => '&',
        '＇' => "'",
        '（' => '(',
        '）' => ')',
        '＊' => '*',
        '＋' => '+',
        '，' => ',',
        '－' => '-',
        '．' => '.',
        '／' => '/',
        '０' => '0',
        '１' => '1',
        '２' => '2',
        '３' => '3',
        '４' => '4',
        '５' => '5',
        '６' => '6',
        '７' => '7',
        '８' => '8',
        '９' => '9',
        '：' => ':',
        '；' => ';',
        '＜' => '<',
        '＝' => '=',
        '＞' => '>',
        '？' => '?',
        '＠' => '@',
        'Ａ' => 'A',
        'Ｂ' => 'B',
        'Ｃ' => 'C',
        'Ｄ' => 'D',
        'Ｅ' => 'E',
        'Ｆ' => 'F',
        'Ｇ' => 'G',
        'Ｈ' => 'H',
        'Ｉ' => 'I',
        'Ｊ' => 'J',
        'Ｋ' => 'K',
        'Ｌ' => 'L',
        'Ｍ' => 'M',
        'Ｎ' => 'N',
        'Ｏ' => 'O',
        'Ｐ' => 'P',
        'Ｑ' => 'Q',
        'Ｒ' => 'R',
        'Ｓ' => 'S',
        'Ｔ' => 'T',
        'Ｕ' => 'U',
        'Ｖ' => 'V',
        'Ｗ' => 'W',
        'Ｘ' => 'X',
        'Ｙ' => 'Y',
        'Ｚ' => 'Z',
        '［' => '[',
        '＼' => '\\',
        '］' => ']',
        '＾' => '^',
        '＿' => '_',
        '｀' => '`',
        'ａ' => 'a',
        'ｂ' => 'b',
        'ｃ' => 'c',
        'ｄ' => 'd',
        'ｅ' => 'e',
        'ｆ' => 'f',
        'ｇ' => 'g',
        'ｈ' => 'h',
        'ｉ' => 'i',
        'ｊ' => 'j',
        'ｋ' => 'k',
        'ｌ' => 'l',
        'ｍ' => 'm',
        'ｎ' => 'n',
        'ｏ' => 'o',
        'ｐ' => 'p',
        'ｑ' => 'q',
        'ｒ' => 'r',
        'ｓ' => 's',
        'ｔ' => 't',
        'ｕ' => 'u',
        'ｖ' => 'v',
        'ｗ' => 'w',
        'ｘ' => 'x',
        'ｙ' => 'y',
        'ｚ' => 'z',
        '｛' => '{',
        '｜' => '|',
        '｝' => '}',
        '～' => '~',
    ];

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
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * toHalfCase.
     *
     * @return string
     */
    public function toHalfCase()
    {
        return strtr($this->subject, static::$fullCaseMap);
    }

    /**
     * toFullCase.
     *
     * @return string
     */
    public function toFullCase()
    {
        return strtr($this->subject, array_flip(static::$fullCaseMap));
    }
}
