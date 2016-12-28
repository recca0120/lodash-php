<?php

namespace Recca0120\String\Extensions;

use ArrayObject;
use MediaWiki\Languages\Data\ZhConversion;

class Converter
{
    protected static $instance;

    protected $default = 'zh-tw';

    private function __construct()
    {
        $this->table = [
            'zh-hans' => new ArrayObject(ZhConversion::$zh2Hans),
            'zh-hant' => new ArrayObject(ZhConversion::$zh2Hant),
            'zh-cn' => new ArrayObject(ZhConversion::$zh2CN + ZhConversion::$zh2Hans),
            'zh-hk' => new ArrayObject(ZhConversion::$zh2HK + ZhConversion::$zh2Hant),
            'zh-mo' => new ArrayObject(ZhConversion::$zh2HK),
            'zh-my' => new ArrayObject(ZhConversion::$zh2CN + ZhConversion::$zh2Hans),
            'zh-sg' => new ArrayObject(ZhConversion::$zh2CN + ZhConversion::$zh2Hans),
            'zh-tw' => new ArrayObject(ZhConversion::$zh2TW + ZhConversion::$zh2Hant),
            'zh' => new ArrayObject([]),
        ];

        // $this->table['zh-cn'] = new ArrayObject(
        //     $this->table['zh-cn']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-hk'] = new ArrayObject(
        //     $this->table['zh-hk']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        // );

        // $this->table['zh-my'] = new ArrayObject(
        //     $this->table['zh-my']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-sg'] = new ArrayObject(
        //     $this->table['zh-sg']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-tw'] = new ArrayObject(
        //     $this->table['zh-tw']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        // );

        // $this->table = [
        //     'zh-hans' => new ArrayObject(ZhConversion::$zh2Hans),
        //     'zh-hant' => new ArrayObject(ZhConversion::$zh2Hant),
        //     'zh-cn' => new ArrayObject(ZhConversion::$zh2CN),
        //     'zh-hk' => new ArrayObject(ZhConversion::$zh2HK),
        //     'zh-mo' => new ArrayObject(ZhConversion::$zh2HK),
        //     'zh-my' => new ArrayObject(ZhConversion::$zh2CN),
        //     'zh-sg' => new ArrayObject(ZhConversion::$zh2CN),
        //     'zh-tw' => new ArrayObject(ZhConversion::$zh2TW),
        //     'zh' => new ArrayObject([]),
        // ];

        // $this->table['zh-cn'] = new ArrayObject(
        //     $this->table['zh-cn']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-hk'] = new ArrayObject(
        //     $this->table['zh-hk']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        // );

        // $this->table['zh-my'] = new ArrayObject(
        //     $this->table['zh-my']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-sg'] = new ArrayObject(
        //     $this->table['zh-sg']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        // );

        // $this->table['zh-tw'] = new ArrayObject(
        //     $this->table['zh-tw']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        // );
    }

    public function convertTo($string, $variant = 'zh-tw')
    {
        $arrayObject = isset($this->table[$variant]) === true ? $this->table[$variant] : $this->table[$this->default];
        $data = $arrayObject->getArrayCopy();

        return strtr($string, $data);
    }

    public static function instance()
    {
        return is_null(static::$instance) === true ? new static() : static::$instance;
    }
}
