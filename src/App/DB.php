<?php

namespace Buzzz\App;

class DB
{
    public static function init($settings)
    {
        ['host' => $host, 'database' => $dbname, 'login' => $login, 'password' => $password] = $settings;
        $db = new \PDO("mysql:host={$host};dbname={$dbname}", $login, $password);
        $db->query("SET NAMES 'utf8mb4'");
        $db->query("SET collation_connection = 'utf8mb4_unicode_ci'");
        return $db;
    }
}