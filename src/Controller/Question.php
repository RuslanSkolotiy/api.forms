<?php

namespace Buzzz\Controller;

use Buzzz\App\Auth;
use Buzzz\App\Request;
use Buzzz\App\Response;

class Question extends Controller {
    private function getPollIdByUUID ($pollId) {
        $poll = \Buzzz\Model\Poll::getByUUID($pollId);
        if ($poll) {
            if ($poll['user_id'] !== Auth::getUserId()) {
                throw new \Exception('', 403);
            }
            return $poll['id'];
        } else {
            new Response('null', 'Елемент не найден');
        }
        return false;
    }

    public function getList($pollUUID)
    {
        $pollId = $this->getPollIdByUUID($pollUUID);
        $list = \Buzzz\Model\Question::getList($pollId);
        return new Response($list, 'Список сформирован');
    }

    public function get($id, $pollUUID)
    {
        $pollId = $this->getPollIdByUUID($pollUUID);
        $item = \Buzzz\Model\Question::get($pollId, $id);
        if (!$item) {
            return new Response(null, 'Елемент не найден');
        }
        return new Response($item, 'Елемент найден');
    }

    public function add($pollUUID)
    {
        $pollId = $this->getPollIdByUUID($pollUUID);
        $data = [
            'name' => Request::input('name', 'Новый вопрос', 'post'),
            'type_id' => Request::input('type_id', 1, 'post'),
        ];
        $id = \Buzzz\Model\Question::add($pollId, $data);
        $item = \Buzzz\Model\Question::get($pollId, $id);
        return new Response($item, 'Елемент создан');
    }

    public function delete($id, $pollUUID)
    {
        $pollId = $this->getPollIdByUUID($pollUUID);
        $item = \Buzzz\Model\Question::get($pollId, $id);
        if (!$item) {
            return new Response(false, 'Елемент не найден');
        }
        \Buzzz\Model\Question::delete($pollId, $id);
        return new Response(true, 'Елемент удалён');
    }

    public function update($id, $pollUUID)
    {
        $pollId = $this->getPollIdByUUID($pollUUID);
        $data = self::getUpdatedFields(['name', 'sort', 'type_id', 'description', 'settings']);
        \Buzzz\Model\Question::update($pollId, $id, $data);
        // Возврат обновленного объекта
        $item = \Buzzz\Model\Question::get($pollId, $id);
        return new Response($item, 'Елемент изменён');
    }
}