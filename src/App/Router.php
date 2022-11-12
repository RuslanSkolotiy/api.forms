<?php

namespace Buzzz\App;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use \Buzzz\Controller\Poll;

class Router
{
    public static function init()
    {
        // Опросы
        SimpleRouter::get('/api/v1/poll', [Poll::class, 'getList']);
        SimpleRouter::get('/api/v1/poll/{guid}', [Poll::class, 'get']);
        SimpleRouter::post('/api/v1/poll', [Poll::class, 'add']);
        SimpleRouter::delete('/api/v1/poll/{guid}', [Poll::class, 'delete']);
        SimpleRouter::post('/api/v1/poll/{guid}', [Poll::class, 'update']);

        // Вопросы
        SimpleRouter::get('/question', [Poll::class, 'add']);

        // Обработка ошибок
        SimpleRouter::error(function (Request $request, \Exception $exception) {
            self::onError($request, $exception);
        });

        SimpleRouter::start();
    }

    public static function onError(Request $request, \Exception $exception)
    {
        switch ($exception->getCode()) {
            // Page not found
            case 404:
                new Response(null, 'Page not found', 404);
            // Forbidden
            case 403:
                new Response(null, 'Forbidden', 403);
        }
    }
}