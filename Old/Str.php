<?php

namespace Recca0120\Library;

class Str
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    protected $subject;

    public function __construct($subject = '')
    {
        $this->subject = $subject;
    }

    public function camelCase()
    {
        return $this->camel();
    }

    public function capitalize()
    {
        return $this->toLowerCase()->ucfirst();
    }

    public function deburr()
    {
        return $this->ascii();
    }

    public function endsWith($target, $position = null)
    {
        $target = new static($target);
        $length = $this->length();
        $position = is_null($position) === true ?
            $length :
            min($position, $length);

        $end = $position;
        $position -= $target->length();

        return $position > 0 && $this->substr($position, $target->length())->value() === $target->value();
    }

    public function escape()
    {
        return $this->htmlentities();
    }

    public function escapeRegExp()
    {
        return new static(preg_replace_callback('/[\^"\$\.\*\+\?\(\)\[\]\{\}\|]/', function ($m) {
            return '\\'.$m[0];
        }, $this->subject));
    }

    public function kebabCase()
    {
        return $this->snake('-');
    }

    public function lowerCase()
    {
        return $this->snake(' ');
    }

    public function lowerFirst()
    {
        return $this->lcfirst();
    }

    public function pad($length = 0, $chars = ' ', $type = STR_PAD_BOTH)
    {
        return str_pad($this->subject, $length, $chars, $type);
    }

    public function padEnd($length, $char = ' ')
    {
        return $this->pad($length, $char, STR_PAD_RIGHT);
    }

    public function padStart($length, $char = ' ')
    {
        return $this->pad($length, $char, STR_PAD_LEFT);
    }

    public function parseInt()
    {
        return (int) $this->subject;
    }

    public function repeat()
    {
    }

    // public function replace()
    // {

    // }

    public function snakeCase()
    {
    }

    public function split()
    {
    }

    public function startCase()
    {
    }

    public function startsWith()
    {
    }

    public function template()
    {
    }

    public function toLower()
    {
    }

    public function toUpper()
    {
    }

    public function trimEnd()
    {
    }

    public function trimStart()
    {
    }

    public function truncate()
    {
    }

    public function unescape()
    {
    }

    public function upperCase()
    {
    }

    public function upperFirst()
    {
    }

    public function words($pattern = null)
    {
        $pattern = is_null($pattern) === true ?
            '/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/' :
            $pattern;

        if ((bool) preg_match_all($pattern, $this->subject, $matches) === false) {
            return new Collection([]);
        }

        return new Collection($matches[0]);
    }

    public function camel()
    {
        if (isset(static::$camelCache[$this->subject])) {
            return static::$camelCache[$this->subject];
        }

        return static::$camelCache[$this->subject] = $this->studly()->lcfirst();
    }

    public function snake($delimiter = '_')
    {
        $key = $this->subject;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (! ctype_lower($this->subject)) {
            $this->subject = preg_replace('/\s+/u', '', $this->subject);

            $this->subject = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $this->subject), 'UTF-8');
        }

        return static::$snakeCache[$key][$delimiter] = new static($this->subject);
    }

    public function studly()
    {
        $value = $this->subject;
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = $this->replace([
            ' ' => '',
        ]);
    }

    public function ascii()
    {
        $value = $this->subject;
        foreach (static::charsArray() as $key => $val) {
            $value = str_replace($val, $key, $value);
        }

        return new static(preg_replace('/[^\x20-\x7E]/u', '', $value));
    }

    /**
     * javascript.
     */
    public function toUpperCase()
    {
        return new static(strtoupper($this->subject));
    }

    public function toLowerCase()
    {
        return new static(strtolower($this->subject));
    }

    public function slice()
    {
        return call_user_func_array([$this, 'substr'], func_get_args());
    }

    /**
     * native.
     */
    public function htmlentities()
    {
        return new static(htmlentities($this->subject));
    }

    public function lcfirst()
    {
        return new static(lcfirst($this->subject));
    }

    public function length()
    {
        return strlen($this->subject);
    }

    public function replace($pattern, $replacement = null)
    {
        if (is_array($pattern) === true && is_null($replacement) === true) {
            return new static(strtr($this->subject, $pattern));
        }

        if (is_callable($replacement) === true) {
            return new static(preg_replace_callback($pattern, $replacement, $this->subject));
        }

        return new static(preg_replace($pattern, $replacement, $this->subject));
    }

    public function substr()
    {
        return new static(call_user_func_array('substr', array_merge(
            [$this->subject],
            func_get_args()
        )));
    }

    public function trim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(trim($this->subject, $characterMask));
    }

    public function ucfirst()
    {
        return new static(ucfirst($this->subject));
    }

    public function ucwords()
    {
        return new static(ucwords($this->subject));
    }

    public function value()
    {
        return $this->subject;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function be($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        if (is_string($value) === true) {
            return new static($value);
        }

        return false;
    }

    /**
     * Returns the replacements for the ascii method.
     *
     * Note: Adapted from Stringy\Stringy.
     *
     * @see https://github.com/danielstjules/Stringy/blob/2.3.1/LICENSE.txt
     *
     * @return array
     */
    protected static function charsArray()
    {
        static $charsArray;

        if (isset($charsArray)) {
            return $charsArray;
        }

        return $charsArray = [
            '0' => ['°', '₀', '۰'],
            '1' => ['¹', '₁', '۱'],
            '2' => ['²', '₂', '۲'],
            '3' => ['³', '₃', '۳'],
            '4' => ['⁴', '₄', '۴', '٤'],
            '5' => ['⁵', '₅', '۵', '٥'],
            '6' => ['⁶', '₆', '۶', '٦'],
            '7' => ['⁷', '₇', '۷'],
            '8' => ['⁸', '₈', '۸'],
            '9' => ['⁹', '₉', '۹'],
            'a' => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا'],
            'b' => ['б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ'],
            'c' => ['ç', 'ć', 'č', 'ĉ', 'ċ'],
            'd' => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ'],
            'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ'],
            'f' => ['ф', 'φ', 'ف', 'ƒ', 'ფ'],
            'g' => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ'],
            'h' => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ'],
            'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ'],
            'j' => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج'],
            'k' => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک'],
            'l' => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ'],
            'm' => ['м', 'μ', 'م', 'မ', 'მ'],
            'n' => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ'],
            'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ'],
            'p' => ['п', 'π', 'ပ', 'პ', 'پ'],
            'q' => ['ყ'],
            'r' => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ'],
            's' => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს'],
            't' => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ'],
            'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ'],
            'v' => ['в', 'ვ', 'ϐ'],
            'w' => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ'],
            'x' => ['χ', 'ξ'],
            'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ'],
            'z' => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ'],
            'aa' => ['ع', 'आ', 'آ'],
            'ae' => ['ä', 'æ', 'ǽ'],
            'ai' => ['ऐ'],
            'at' => ['@'],
            'ch' => ['ч', 'ჩ', 'ჭ', 'چ'],
            'dj' => ['ђ', 'đ'],
            'dz' => ['џ', 'ძ'],
            'ei' => ['ऍ'],
            'gh' => ['غ', 'ღ'],
            'ii' => ['ई'],
            'ij' => ['ĳ'],
            'kh' => ['х', 'خ', 'ხ'],
            'lj' => ['љ'],
            'nj' => ['њ'],
            'oe' => ['ö', 'œ', 'ؤ'],
            'oi' => ['ऑ'],
            'oii' => ['ऒ'],
            'ps' => ['ψ'],
            'sh' => ['ш', 'შ', 'ش'],
            'shch' => ['щ'],
            'ss' => ['ß'],
            'sx' => ['ŝ'],
            'th' => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
            'ts' => ['ц', 'ც', 'წ'],
            'ue' => ['ü'],
            'uu' => ['ऊ'],
            'ya' => ['я'],
            'yu' => ['ю'],
            'zh' => ['ж', 'ჟ', 'ژ'],
            '(c)' => ['©'],
            'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ'],
            'B' => ['Б', 'Β', 'ब'],
            'C' => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ'],
            'D' => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ'],
            'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə'],
            'F' => ['Ф', 'Φ'],
            'G' => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ'],
            'H' => ['Η', 'Ή', 'Ħ'],
            'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ'],
            'K' => ['К', 'Κ'],
            'L' => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल'],
            'M' => ['М', 'Μ'],
            'N' => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν'],
            'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ'],
            'P' => ['П', 'Π'],
            'R' => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ'],
            'S' => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ'],
            'T' => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ'],
            'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ'],
            'V' => ['В'],
            'W' => ['Ω', 'Ώ', 'Ŵ'],
            'X' => ['Χ', 'Ξ'],
            'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ'],
            'Z' => ['Ź', 'Ž', 'Ż', 'З', 'Ζ'],
            'AE' => ['Ä', 'Æ', 'Ǽ'],
            'CH' => ['Ч'],
            'DJ' => ['Ђ'],
            'DZ' => ['Џ'],
            'GX' => ['Ĝ'],
            'HX' => ['Ĥ'],
            'IJ' => ['Ĳ'],
            'JX' => ['Ĵ'],
            'KH' => ['Х'],
            'LJ' => ['Љ'],
            'NJ' => ['Њ'],
            'OE' => ['Ö', 'Œ'],
            'PS' => ['Ψ'],
            'SH' => ['Ш'],
            'SHCH' => ['Щ'],
            'SS' => ['ẞ'],
            'TH' => ['Þ'],
            'TS' => ['Ц'],
            'UE' => ['Ü'],
            'YA' => ['Я'],
            'YU' => ['Ю'],
            'ZH' => ['Ж'],
            ' ' => ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"],
        ];
    }

    private function createCompounder($callback)
    {
        return $this->deburr()->words()->reduce($callback, '');
    }

    // use Native;

    // public $str;

    // public function __construct($str = '')
    // {
    //     $this->str = $str;
    // }

    // public function set($str)
    // {
    //     $this->str = $str;

    //     return $this;
    // }

    // public function convertTo($variant = 'zh-tw')
    // {
    //     return new static(Converter=>=>instance()->convertTo($this->value(), $variant));
    // }

    // public function toHalfCase()
    // {
    //     return new static((new FullCase($this->str))->toHalfCase());
    // }

    // public function toFullCase()
    // {
    //     return new static((new FullCase($this->str))->toFullCase());
    // }

    // public function chineseToNumber()
    // {
    //     return new static((new Chinese($this->str))->toNumber());
    // }

    // public function value()
    // {
    //     return $this->str;
    // }

    // public function __toString()
    // {
    //     return $this->value();
    // }

    // public static function make($str)
    // {
    //     return new static($str);
    // }
}
