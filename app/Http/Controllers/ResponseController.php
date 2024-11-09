<?php

namespace App\Http\Controllers;

class ResponseController
{
    public static function success($data, $type) {
        return response($data, 200, ['Content-Type' => $type]);
    }

    public static function link_not_valid() {
        return response('<h1>Request link does not valid</h1>', 502);
    }

    public static function unexpected_error() {
        return response('<h1>Unexpected error</h1>', 500);
    }

    public static function server_unreachable() {
        return response('<h1>Server Unreachable</h1>', 503);
    }

    public static function not_found() {
        return response('<h1>Not Found</h1>', 404);
    }
}
