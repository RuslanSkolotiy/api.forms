<?php

namespace Buzzz\Controller;

use Buzzz\App\Response;
use Buzzz\Model\Poll;

class Published
{
    public function getPoll($uuid)
    {
        $poll = Poll::getByUUID($uuid);
        if (!$poll) {
            return new Response(null, 'Опрос не найден');
        }
        if (!$poll['published']) {
            return new Response(null, 'Опрос не опубликован');
        }
        return new Response($poll, 'Опрос найден');
    }
}