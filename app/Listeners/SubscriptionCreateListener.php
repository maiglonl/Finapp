<?php

namespace Finapp\Listeners;

use Finapp\Repositories\SubscriptionRepository;
use Finapp\Events\IuguSubscriptionCreatedEvent;
use Finapp\Models\Subscription;

class SubscriptionCreateListener{
	private $repository;
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct(SubscriptionRepository $repository){
		$this->repository = $repository;
	}

	/**
	 * Handle the event.
	 *
	 * @param  IuguSubscriptionCreatedEvent  $event
	 * @return void
	 */
	public function handle(IuguSubscriptionCreatedEvent $event){
		$iuguSubscription = $event->getIuguSubscription();
		$invoice = $iuguSubscription->recent_invoices[0];

		$this->repository->create([
			'expires_at' => $iuguSubscription->expires_at,
			'code' => $iuguSubscription->id,
			'user_id' => $event->getUserId(),
			'plan_id' => $event->getPlanId(),
			'status' => $invoice->status == 'paid' ? Subscription::STATUS_ATIVE : Subscription::STATUS_INATIVE
		]);
	}
}
