<?php

namespace Buzzz\App;

use Buzzz\Controller\Published;
use Buzzz\Controller\Question;
use Buzzz\Controller\QuestionType;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use \Buzzz\Controller\Poll;
use \Buzzz\App\Middleware\AuthMiddleware;
use \Buzzz\App\Middleware\PollAccessMiddleware;

class Router
{
    const API_VERSION = '1.0.0';
    public static function init()
    {
        // Main page
        SimpleRouter::get('/', function() {
            new Response(['version' => self::API_VERSION], 'Buzzz forms service API');
        });

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

        // Типы вопросов
        SimpleRouter::group(['prefix' => '/api/v1/questionType', 'middleware' => AuthMiddleware::class], function () {
            SimpleRouter::get('/', [QuestionType::class, 'getList']);
            SimpleRouter::get('/{id}', [QuestionType::class, 'get']);
        });

        // Опубликованный опрос
        SimpleRouter::group(['prefix' => '/api/v1/published/{id}/'], function () {
            SimpleRouter::get('', [Published::class, 'getPoll']);
        });

        // Обработка ошибок
        SimpleRouter::error(function (Request $request, \Exception $exception) {
            self::onError($request, $exception);
        });

        SimpleRouter::start();
    }

    public static function onError(Request $request, \Exception $exception)
    {
        // TODO добавить логирование
        switch ($exception->getCode()) {
            case 404:
                new Response(null, 'Page not found', 404);
                break;
            case 403:
                new Response(null, 'Forbidden', 403);
                break;
            case 401:
                new Response(null, 'Not authorized', 401);
                break;
            default:
                new Response(null, 'Unknown Error', 520);
                break;
        }
    }
}