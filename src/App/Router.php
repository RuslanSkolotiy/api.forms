<?php

namespace Buzzz\App;

use Buzzz\Controller\Question;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use \Buzzz\Controller\Poll;
use \Buzzz\App\Middleware\AuthMiddleware;
use \Buzzz\App\Middleware\PollAccessMiddleware;

class Router
{
    public static function init()
    {
        // Опросы
        SimpleRouter::group(['prefix' => '/api/v1/poll', 'middleware' => AuthMiddleware::class], function () {
            SimpleRouter::get('', [Poll::class, 'getList']);
            SimpleRouter::get('/{guid}', [Poll::class, 'get']);
            SimpleRouter::post('', [Poll::class, 'add']);
            SimpleRouter::delete('/{guid}', [Poll::class, 'delete']);
            SimpleRouter::post('/{guid}', [Poll::class, 'update']);
        });

        // Вопросы
        SimpleRouter::group(['prefix' => '/api/v1/question/{pollId}', 'middleware' => AuthMiddleware::class], function () {
            SimpleRouter::get('/', [Question::class, 'getList']);
            SimpleRouter::get('/{id}', [Question::class, 'get']);
            SimpleRouter::post('/', [Question::class, 'add']);
            SimpleRouter::delete('/{id}', [Question::class, 'delete']);
            SimpleRouter::post('/{id}', [Question::class, 'update']);
        });

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
            // Unauthorized
            case 401:
                new Response(null, 'Unauthorized', 401);
        }
    }
}