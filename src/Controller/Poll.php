<?php

namespace Buzzz\Controller;

use Buzzz\App\Request;
use Buzzz\App\Response;

class Poll
{
    public function getList()
    {
        $list = \Buzzz\Model\Poll::getList();
        return new Response($list, 'Список сформирован');
    }

    public function get($uuid)
    {
        $item = \Buzzz\Model\Poll::get($uuid);
        if (!$item) {
            return new Response(null, 'Елемент не найден');
        }
        return new Response($item, 'Елемент найден');
    }

    public function add()
    {
        $name = Request::input('name', null, 'post');
        $user_id = '996ad860-2a9a-504f-8861-aeafd0b2ae29';
        $data = [
            'name' => $name,
            'user_id' => $user_id
        ];
        $id = \Buzzz\Model\Poll::add($user_id, $data);
        $item = \Buzzz\Model\Poll::getById($id);
        return new Response($item, 'Елемент создан');
    }

    public function delete($uuid)
    {
        $item = \Buzzz\Model\Poll::get($uuid);
        if (!$item) {
            return new Response(false, 'Елемент не найден');
        }
        \Buzzz\Model\Poll::delete($uuid);
        return new Response(true, 'Елемент удалён');
    }

    public function update($uuid)
    {
        $name = Request::input('name', null, 'post');
        $user_id = '996ad860-2a9a-504f-8861-aeafd0b2ae29';
        $data = [
            'name' => $name
        ];
        \Buzzz\Model\Poll::update($uuid, $user_id, $data);
        $item = \Buzzz\Model\Poll::get($uuid);
        return new Response($item, 'Елемент изменён');
    }
}