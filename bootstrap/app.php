<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Http;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            $token = env('TELEGRAM_BOT_TOKEN');
            $chat_id = env('TELEGRAM_ADMIN_CHAT_ID');

            $text = '<u>Logging</u>' . PHP_EOL;
            $text .= '<b>' . get_class($e) . '</b>: ' . $e->getMessage() . PHP_EOL;
            $text .= 'File: ' . $e->getFile() . '(' . $e->getLine() . ')' . PHP_EOL;

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode' => 'html',
            ])->json();
        });
    })->create();
