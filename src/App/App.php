<?php

namespace Buzzz\App;

class App
{
    public static $DB;
    public function init()
    {
        $settings = require_once __DIR__ . '/../../bitrix/.settings.php';

        self::$DB = DB::init($settings['connections']['value']['default']);
        Router::init();
    }
}