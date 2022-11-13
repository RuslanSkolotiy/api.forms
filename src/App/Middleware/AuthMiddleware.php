<?php

namespace Buzzz\App\Middleware;

use Buzzz\App\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthMiddleware implements IMiddleware {

    public function handle(Request $request): void
    {
        $jwt = $_COOKIE['JWT'];
        $secret_key = $_ENV['JWT_SECRET_KEY'];
        try {
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            Auth::setUserId($decoded->uid);
        } catch (\Exception $e) {
            throw new \Exception("Not authorized", 401);
        }
    }
}