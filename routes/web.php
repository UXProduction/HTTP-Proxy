<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyController;

Route::any('/{path?}', [ProxyController::class, 'handler'])->where('path', '(.*)');
