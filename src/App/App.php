<?php

namespace Buzzz\App;

class App
{
    public static $DB;
    public static $DOCUMENT_ROOT;
    public function init()
    {
       // DOCUMENT_ROOT
        self::$DOCUMENT_ROOT = realpath(__DIR__ . '/../..');
        // Load .env
        $dotenv = \Dotenv\Dotenv::createImmutable(self::$DOCUMENT_ROOT);
        $dotenv->load();
        // Load configuration
        $settings = require_once self::$DOCUMENT_ROOT . '/bitrix/.settings.php';
        // Init CORS
        Cors::init($_ENV['CORS_DOMAIN']);
        // Start session
        session_start();
        // Init database
        self::$DB = DB::init($settings['connections']['value']['default']);
        // Init routing
        Router::init();
    }
}