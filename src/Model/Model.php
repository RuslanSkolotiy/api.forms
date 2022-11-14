<?php
namespace Buzzz\Model;

abstract class Model {
    public static function prepareQueryFields($fieldsData, $separator = ', '): string
    {
        $prepareData = [];
        foreach ($fieldsData as $key => $value) {
            $prepareData[] = "$key = :$key";
        }
        return implode($separator, $prepareData);
    }
}