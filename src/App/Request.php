<?php

namespace Buzzz\App;

class Request
{
    public static function input($index = null, $defaultValue = null, ...$methods)
    {
        if ($index !== null) {
            return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
        }
        return request()->getInputHandler();
    }
}