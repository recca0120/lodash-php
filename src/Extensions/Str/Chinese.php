<?php

namespace Recca0120\Library\Extensions\Str;

class Chinese
{
    public static $numberUnits = [
        '個' => 1,
        '十' => 10,
        '百' => 100,
        '千' => 1000,
        '萬' => 10000,
    ];

    protected $str;

    public function __construct($str)
    {
        $this->str = $str;
    }

    public function toNumber()
    {
        $sum = 0;

        if (!preg_match_all('/(?P<number>[一二三四五六七八九]+)?(?P<unit>[萬千百十])?/u', $this->str, $matches, PREG_SET_ORDER)) {
            return $sum;
        }

        $sum = 0;
        foreach ($matches as $token) {
            $unit = empty($token['unit']) === false ? $token['unit'] : '個';
            $unit = static::$numberUnits[$unit];
            if (empty($token['number']) === true) {
                $sum = ($sum === 0 ? 1 : $sum) * $unit;

                continue;
            }

            $number = $token['number'];
            $number = strtr($number, [
                '零' => 0,
                '一' => 1,
                '二' => 2,
                '三' => 3,
                '四' => 4,
                '五' => 5,
                '六' => 6,
                '七' => 7,
                '八' => 8,
                '九' => 9,
            ]);

            if ($unit >= 10000) {
                $sum = $sum * $unit;
            }

            $sum += ($number * $unit);
        }

        return $sum;
    }
}
