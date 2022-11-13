<?php

namespace Buzzz\Controller;

use Buzzz\App\Auth;
use Buzzz\App\Response;

class QuestionType {
    public function getList()
    {
        $list = \Buzzz\Model\QuestionType::getList();
        return new Response($list, 'Список сформирован');
    }

    public function get($id)
    {
        $item = \Buzzz\Model\QuestionType::get($id);
        if (!$item) {
            return new Response(null, 'Елемент не найден');
        }
        return new Response($item, 'Елемент найден');
    }
}