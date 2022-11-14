<?php

namespace Buzzz\Controller;

use Buzzz\App\Request;

abstract class Controller {

    /**
     * Получает только те поля, которые были переданы POSTом: getUpdatedFields([field1, field2])
     * Можно установить значение по умолчанию для отсутсвующих полей: getUpdatedFields([field1 => default_value])
     * @param $fields
     * @return array
     */
    public static function getUpdatedFields($fields)
    {
        $data = [];
        foreach ($fields as $key => $value) {
            if (is_int($key)) {
               $realKey = $value;
               $defaultValue = null;
            } else {
                $realKey = $key;
                $defaultValue = $value;
            }
            $updateValue = Request::input($realKey, $defaultValue, 'post');
            if ($updateValue !== null) {
                $data[$realKey] = $updateValue;
            }
        }
        return $data;

    }
}