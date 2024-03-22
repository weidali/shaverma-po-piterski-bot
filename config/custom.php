<?php

return [
	'local_url' => env('LOCAL_APP_URL', ''),
	'telegram' => [
		'token' => env('TELEGRAM_BOT_TOKEN', ''),
		'admin_chat_id' => env('TELEGRAM_ADMIN_CHAT_ID', ''),
	],
];
