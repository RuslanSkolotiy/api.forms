<?php

namespace Buzzz\App;

class Cors {
    /**
     * Example $allowedOrigins = array('(http(s)://)?(www\.)?my\-domain\.com');
     * @param $allowedOrigins
     * @return void
     */
    public static function init($allowedOrigin)
    {
        header('Access-Control-Allow-Origin: ' . $allowedOrigin);
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }
}