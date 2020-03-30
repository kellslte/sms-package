<?php

return [
	'default' => \Nologo\SMS\Classes\BulkSMSNigeria::class,
	'sender' => env('SMS_SENDER', 'MyApp'),
	
	'bulk_sms_nigeria' => [
		'token' => env('BULK_SMS_NIGERIA_TOKEN'),
		'dnd' => env('BULK_SMS_NIGERIA_DND', 2),
	],

	'smart_sms' => [
		'token' => env('SMART_SMS_TOKEN'),
	]
];