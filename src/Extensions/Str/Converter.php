<?php

namespace Recca0120\Library\Extensions\Str;

use ArrayObject;

class Converter
{
    protected static $instance;

    protected $default = 'zh-tw';

    private function __construct()
    {
        // $this->table = [
        //     'zh-hans' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2Hans),
        //     'zh-hant' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2Hant),
        //     'zh-cn' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2CN),
        //     'zh-hk' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2HK),
        //     'zh-mo' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2HK),
        //     'zh-my' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2CN),
        //     'zh-sg' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2CN),
        //     'zh-tw' => new ArrayObject(\MediaWiki\Languages\Data\ZhConversion::$zh2TW),
        //     'zh' => new ArrayObject([]),
        // ];

        $path = __DIR__.'/../../../resources/Mediawiki/Languages/Data/';

        $this->table = [
            'zh-hans' => new ArrayObject(require($path.'/zh2Hans.php')),
            'zh-hant' => new ArrayObject(require($path.'/zh2Hant.php')),
            'zh-cn' => new ArrayObject(require($path.'/zh2CN.php')),
            'zh-hk' => new ArrayObject(require($path.'/zh2HK.php')),
            'zh-tw' => new ArrayObject(require($path.'/zh2TW.php')),
            'zh' => new ArrayObject([]),
        ];

        $this->table['zh-mo'] = $this->table['zh-hk'];
        $this->table['zh-my'] = $this->table['zh-cn'];
        $this->table['zh-sg'] = $this->table['zh-cn'];

        $this->table['zh-cn'] = new ArrayObject(
            $this->table['zh-cn']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        );

        $this->table['zh-hk'] = new ArrayObject(
            $this->table['zh-hk']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        );

        $this->table['zh-my'] = new ArrayObject(
            $this->table['zh-my']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        );

        $this->table['zh-sg'] = new ArrayObject(
            $this->table['zh-sg']->getArrayCopy() + $this->table['zh-hans']->getArrayCopy()
        );

        $this->table['zh-tw'] = new ArrayObject(
            $this->table['zh-tw']->getArrayCopy() + $this->table['zh-hant']->getArrayCopy()
        );
    }

    public function convertTo($str, $variant = 'zh-TW')
    {
        $variant = strtolower($variant);
        $arrayObject = isset($this->table[$variant]) === true ? $this->table[$variant] : $this->table[$this->default];
        $data = $arrayObject->getArrayCopy();

        return strtr($str, $data);
    }

    public static function instance()
    {
        return is_null(static::$instance) === true ? new static() : static::$instance;
    }
}
