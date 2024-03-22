<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return;
});

Route::get('getMe', function () {
    $token = env('TELEGRAM_BOT_TOKEN');
    $res = Http::get("https://api.telegram.org/bot{$token}/getUpdates")->json();

    return response()->json($res);
});
