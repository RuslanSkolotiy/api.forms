<?php

namespace Buzzz\Model;

use \Buzzz\App\App;
use Buzzz\App\Auth;
use Ramsey\Uuid\Uuid;

class QuestionType
{
    const table_name = 'question_type';

    public static function getList(): array
    {
        $data = [];
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'sort' => $row['sort'],
            ];
        }
        return $data;
    }

    public static function get($id)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch()) {
            return [
                'id' => $row['id'],
                'name' => $row['name'],
                'sort' => $row['sort'],
            ];
        }
        return false;
    }
}