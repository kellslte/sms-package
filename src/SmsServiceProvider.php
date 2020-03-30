<?php

namespace Nologo\SMS;


use illuminate\Support\ServiceProvider;

/**
 * 
 */
class SmsServiceProvider extends ServiceProvider
{
	
	function boot()
	{

		$this->publishes([
				__DIR__.'/config/nologo-sms.php' => config_path('sms.php')
			]);

		$this->mergeConfigFrom(
			__DIR__.'/config/nologo-sms.php',
			'SMS'
		);

	}

}