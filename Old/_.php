<?php

namespace Recca0120\Library;

class _
{
    public static function __callStatic($method, $parameters)
    {
        $value = array_shift($parameters);

        $callers = [
            Str::class,
            Arr::class,
        ];

        foreach ($callers as $caller) {
            if (($class = call_user_func([$caller, 'be'], $value)) !== false) {
                $result = call_user_func_array([$class, $method], $parameters);

                return method_exists($result, 'value') === true ?
                    $result->value() :
                    $result;
            }
        }
    }
}
