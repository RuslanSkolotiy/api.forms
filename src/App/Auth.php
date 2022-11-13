<?php

namespace Buzzz\App;

class Auth
{
    public static $userId = null;

    public static function isAuthorized(): bool
    {
        return self::$userId !== null;
    }

    public static function getUserId()
    {
        return self::$userId;
    }

    public static function setUserId($userId): void
    {
        self::$userId = $userId;
    }


}