<?php

namespace Finapp\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Finapp\Events\BankStoredEvent;
use Finapp\Listeners\BankLogoUploadListener;

class EventServiceProvider extends ServiceProvider{

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		BankStoredEvent::class => [
			BankLogoUploadListener::class
		]
	];
	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot(){
		parent::boot();

		//
	}
}
