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
            $url = config('custom.local_url');
        } else {
            $url = config('app.url');
        }

        $url = parse_url($url);
        if ($url['scheme'] != 'https') {
            echo 'Please, use https protocol on APP_URL env variable';
            return;
        }

        dump($url['host']);

        $token = config('custom.telegram.token');

        $response = Http::post("https://api.telegram.org/bot{$token}/setWebhook", [
            'url' => $url,
        ])->json();

        if ($response['ok']) {
            echo $response['descripion'];
        } else {
            dump($response);
        }
    }
}
