<?php

namespace Buzzz\Model;

use \Buzzz\App\App;
use Ramsey\Uuid\Uuid;

class Poll
{
    const table_name = 'poll';

    public static function getList(): array
    {
        $data = [];
        $stmt = App::$DB->query("SELECT * FROM " . self::table_name);
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

    public static function get($uuid)
    {
        $stmt = App::$DB->prepare("SELECT * FROM " . self::table_name . " WHERE uuid = :uuid");
        $stmt->execute(['uuid' => $uuid]);
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

    public static function add($user_id, $data)
    {
        $uuid = Uuid::uuid4();
        $stmt = App::$DB->prepare("INSERT INTO " . self::table_name . " SET uuid=:uuid, user_id=:user_id, name=:name");
        $stmt->execute([
            'uuid' => $uuid,
            'user_id' => $data['user_id'],
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

    public static function update($uuid, $user_id, $data) {
        $stmt = App::$DB->prepare("UPDATE " . self::table_name . " SET name=:name WHERE uuid=:uuid AND user_id=:user_id");
        $stmt->execute([
            'uuid' => $uuid,
            'user_id' => $user_id,
            'name' => $data['name'],
        ]);
    }
}