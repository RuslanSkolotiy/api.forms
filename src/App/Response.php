<?php

namespace Buzzz\App;

use Pecee\SimpleRouter\SimpleRouter;

class Response
{
    public function __construct($content, $message = '', $code = 200)
    {
        SimpleRouter::response()->httpCode($code);
        return SimpleRouter::response()->json(
            [
                'content' => $content,
                '$message' => $code,
                'message' => $message,
            ]
        );
    }
}