<?php

namespace Finapp\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Finapp\Events\BankStoredEvent;
use Finapp\Events\BillStoredEvent;
use Finapp\Events\IuguSubscriptionCreatedEvent;
use Finapp\Listeners\BankLogoUploadListener;
use Finapp\Listeners\BankAccountSetDefaultListener;
use Finapp\Listeners\BankAccountUpdateBalanceListener;
use Finapp\Listeners\SubscriptionCreateListener;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class EventServiceProvider extends ServiceProvider{

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		BankStoredEvent::class => [
			BankLogoUploadListener::class
		],
		BillStoredEvent::class => [
			BankAccountUpdateBalanceListener::class
		],
		RepositoryEntityCreated::class => [
			BankAccountSetDefaultListener::class 
		],
		RepositoryEntityUpdated::class => [
			BankAccountSetDefaultListener::class 
		],
		IuguSubscriptionCreatedEvent::class => [
			SubscriptionCreateListener::class 
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
