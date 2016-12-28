<?php

require __DIR__.'/ZhConversion.php';

$class = Mediawiki\Languages\Data\ZhConversion::class;

foreach (get_class_vars($class) as $key => $value) {
    file_put_contents(
        __DIR__.'/'.$key.'.php',
        // serialize($value)
        '<?php'."\n\n return ".str_replace(['array (', ')'], ['[', ']'], var_export($value, true)).';'
    );
}

unlink(__DIR__.'/ZhConversion.php');
