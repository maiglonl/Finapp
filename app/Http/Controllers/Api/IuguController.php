<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Finapp\Iugu\OrderManager;
use Finapp\Iugu\SubscriptionManager;
use Illuminate\Http\Request;
use Finapp\Mail\FirstSubscriptionPaid;

class IuguController extends Controller{

	private $orderManager;
	private $subscriptionManager;

	public function __construct(OrderManager $orderManager, SubscriptionManager $subscriptionManager){
		$this->orderManager = $orderManager;
		$this->subscriptionManager = $subscriptionManager;
	}

	public function hooks(Request $request){
		$event = $request->get('event');
		$data = $request->get('data', []);
		switch ($event) {
			case 'invoice.created':
				$this->orderManager->create($data);
				break;
			case 'invoice.status_changed':
				if($data['status'] == 'paid'){
					$this->orderManager->paid($data);
				}
				break;
			case 'subscription.renewed':
				$subscription = $this->subscriptionManager->renew($data);
				if($subscription && $subscription->orders()->where('status', Order::STATUS_PAID)->count() == 1){
					\Mail::to($subscription->user)->send(new FirstSubscriptionPaid($subscription));
				}
				break;
		}
	}
}
