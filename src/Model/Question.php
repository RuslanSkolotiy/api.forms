<?php

namespace Buzzz\Model;

use \Buzzz\App\App;
use Buzzz\App\Auth;
use Ramsey\Uuid\Uuid;

class Question
{
    const table_name = 'question';

    public static function getList($pollId): array
    {
        $data = [];
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE poll_id = :poll_id");
        $stmt->execute(['poll_id' => $pollId]);
        while ($row = $stmt->fetch()) {
            $data[] = [
                'id' => $row['id'],
                'poll_id' => $row['poll_id'],
                'type_id' => $row['type_id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'sort' => $row['sort'],
                'settings' => $row['settings'],
            ];
        }
        return $data;
    }

    public static function get($pollId, $id)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE poll_id = :poll_id AND id = :id");
        $stmt->execute(['id' => $id, 'poll_id' => $pollId]);
        if ($row = $stmt->fetch()) {
            return [
                'id' => $row['id'],
                'poll_id' => $row['poll_id'],
                'type_id' => $row['type_id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'sort' => $row['sort'],
                'settings' => $row['settings'],
            ];
        }
        return false;
    }

    public static function add($pollId, $data)
    {
        $stmt = App::$DB->prepare("INSERT INTO " . self::table_name . " SET poll_id = :poll_id, name = :name, type_id = :type_id");
        $stmt->execute([
            'poll_id' => $pollId,
            'name' => $data['name'],
            'type_id' => $data['type_id']
        ]);
        return App::$DB->lastInsertId();
    }

    public static function delete($pollId, $id)
    {
        $stmt = App::$DB->prepare("DELETE FROM " . self::table_name . " WHERE  poll_id = :poll_id AND id = :id");
        $stmt->execute([
            'id' => $id,
            'poll_id' => $pollId,
        ]);
        return true;
    }

    public static function update($pollId, $id, $data) {
        $stmt = App::$DB->prepare("UPDATE " . self::table_name . " SET name=:name, sort = :sort, settings = :settings WHERE poll_id = :poll_id AND id=:id");
        $stmt->execute([
            'poll_id' => $pollId,
            'id' => $id,
            'name' => $data['name'],
            'sort' => $data['sort'],
            'settings' => $data['settings'],

        ]);
    }
}