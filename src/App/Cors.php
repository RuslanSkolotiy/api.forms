<?php

namespace Buzzz\App;

class Cors
{
    /**
     * Example $allowedOrigins = array('(http(s)://)?(www\.)?my\-domain\.com');
     * @param $allowedOrigins
     * @return void
     */
    public static function init($allowedOrigin)
    {
        if (isset($allowedOrigin)) {
            header("Access-Control-Allow-Origin: {$allowedOrigin}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
    }
}