<?php

namespace Buzzz\App;

class Cors {
    /**
     * Example $allowedOrigins = array('(http(s)://)?(www\.)?my\-domain\.com');
     * @param $allowedOrigins
     * @return void
     */
    public static function init($allowedOrigins)
    {
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {
            foreach ($allowedOrigins as $allowedOrigin) {
                if (preg_match('#' . $allowedOrigin . '#', $_SERVER['HTTP_ORIGIN'])) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                    header('Access-Control-Max-Age: 1000');
                    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
                    break;
                }
            }
        }
    }
}