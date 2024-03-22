<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class SetWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-webhook-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set webhook url';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (App::environment('local')) {
            $app_url = config('custom.local_url');
        } else {
            $app_url = config('app.url');
        }

        $url = parse_url($app_url);
        if ($url['scheme'] != 'https') {
            echo 'Please, use https protocol on APP_URL env variable';
            return;
        }

        echo 'Attemting to set webhook on url: ' . $url['host'] . '/api/webhook' . PHP_EOL;

        $token = config('custom.telegram.token');
        $response = Http::post("https://api.telegram.org/bot{$token}/setWebhook", [
            'url' => $app_url . '/api/webhook',
        ])->json();

        if (!$response['ok']) {
            echo 'Error: ' . $response['error_code'] . PHP_EOL;
        }
        echo $response['description'];
    }
}
