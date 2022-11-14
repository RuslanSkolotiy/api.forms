<?php

namespace Buzzz\Model;

use \Buzzz\App\App;
use Ramsey\Uuid\Uuid;

class Poll extends Model
{
    const table_name = 'poll';


    public static function getList($userId): array
    {
        $data = [];
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        while ($row = $stmt->fetch()) {
            $data[] = [
                'uuid' => $row['uuid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'published' => $row['published'],
            ];
        }
        return $data;
    }

    public static function get($uuid, $userId)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE uuid = :uuid AND user_id = :user_id");
        $stmt->execute(['uuid' => $uuid, 'user_id' => $userId]);
        if ($row = $stmt->fetch()) {
            return [
                'uuid' => $row['uuid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'published' => $row['published'],
            ];
        }
        return false;
    }

    public static function getById($id)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch()) {
            return [
                'uuid' => $row['uuid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'published' => $row['published'],
            ];
        }
        return false;
    }

    public static function getByUUID($uuid)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE uuid = :uuid");
        $stmt->execute(['uuid' => $uuid]);
        if ($row = $stmt->fetch()) {
            return [
                'id' => $row['id'],
                'uuid' => $row['uuid'],
                'name' => $row['name'],
                'user_id' => $row['user_id'],
                'description' => $row['description'],
                'published' => $row['published'],
            ];
        }
        return false;
    }

    public static function add($userId, $data)
    {
        $uuid = Uuid::uuid4();
        $stmt = App::$DB->prepare("INSERT INTO " . self::table_name . " SET uuid = :uuid, user_id = :user_id, name = :name");
        $stmt->execute([
            'uuid' => $uuid,
            'user_id' => $userId,
            'name' => $data['name'],
        ]);
        return App::$DB->lastInsertId();
    }

    public static function delete($uuid)
    {
        $stmt = App::$DB->prepare("DELETE FROM " . self::table_name . " WHERE uuid = :uuid");
        $stmt->execute([
            'uuid' => $uuid
        ]);
        return true;
    }

    public static function update($uuid, $userId, $data)
    {
        $values = self::prepareQueryFields($data);
        $stmt = App::$DB->prepare("UPDATE " . self::table_name . " SET $values WHERE uuid = :uuid AND user_id = :user_id");

        $stmt->execute(array_merge($data, [
            'uuid' => $uuid,
            'user_id' => $userId,
        ]));
    }
}