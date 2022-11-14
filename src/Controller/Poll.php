<?php

namespace Buzzz\Controller;

use Buzzz\App\Auth;
use Buzzz\App\Request;
use Buzzz\App\Response;

class Poll
{
    public function getList()
    {
        $list = \Buzzz\Model\Poll::getList(Auth::getUserId());
        return new Response($list, 'Список сформирован');
    }

    public function get($uuid)
    {
        $item = \Buzzz\Model\Poll::get($uuid, Auth::getUserId());
        if (!$item) {
            return new Response(null, 'Елемент не найден');
        }
        return new Response($item, 'Елемент найден');
    }

    public function add()
    {
        $name = Request::input('name', 'Новый опрос', 'post');
        $type_id = Request::input('type_id', 1, 'post');
        $data = [
            'name' => $name,
            'type_id' => $type_id
        ];
        $id = \Buzzz\Model\Poll::add(Auth::getUserId(), $data);
        $item = \Buzzz\Model\Poll::getById($id);
        return new Response($item, 'Елемент создан');
    }

    public function delete($uuid)
    {
        $item = \Buzzz\Model\Poll::get($uuid, Auth::getUserId());
        if (!$item) {
            return new Response(false, 'Елемент не найден');
        }
        \Buzzz\Model\Poll::delete($uuid);
        return new Response(true, 'Елемент удалён');
    }

    public function update($uuid)
    {
        $data = [
            'name' => Request::input('name', '', 'post'),
            'description' => $name = Request::input('description', '', 'post'),
        ];
        \Buzzz\Model\Poll::update($uuid, Auth::getUserId(), $data);
        $item = \Buzzz\Model\Poll::get($uuid, Auth::getUserId());
        return new Response($item, 'Елемент изменён');
    }
}