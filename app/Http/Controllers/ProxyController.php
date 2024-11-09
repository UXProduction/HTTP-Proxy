<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ResponseController;

class ProxyController extends Controller
{
    private string $remote;

    public function __construct()
    {
        $this->remote = config('app.remote_url');
    }

    public function handler(string $path = null) {
        if(Request::host() == config('app.url')) {
            return $this->get($path);
        } else {
            return ResponseController::link_not_valid();
        }
    }

    private function get($path) {
        try {
            $response = Http::get('http://'.$this->remote.'/'.$path);
        } catch (ConnectionException $e) {
            switch($e->getCode()) {
                case 0:
                    return ResponseController::server_unreachable();
                case 404:
                    return ResponseController::not_found();
                default:
                    return ResponseController::unexpected_error();
            }
        }
        try {
            $ext = explode('.', $path)[1];
        } catch (\ErrorException $e) {
            $ext = ' ';
        }
        switch($ext) {
            case 'css':
                $type = 'text/css';
                break;
            case 'mp3':
                $type = 'audio/mpeg';
                break;
            default:
                $type = 'text/html';
        }
        return ResponseController::success($response->body(), $type);
    }
}
