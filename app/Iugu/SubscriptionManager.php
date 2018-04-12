<?php
namespace Finapp\Iugu;

use Finapp\Repositories\SubscriptionRepository;
use Finapp\Models\Subscription;
use Finapp\Criteria\FindByUserCriteria;
use Carbon\Carbon;

class SubscriptionManager{

	private $iuguSubscriptionClient;
	private $subscriptionRepository;

	public function __construct(
		IuguSubscriptionClient $iuguSubscriptionClient,
		SubscriptionRepository $subscriptionRepository
	){
		$this->iuguSubscriptionClient = $iuguSubscriptionClient;
		$this->subscriptionRepository = $subscriptionRepository;
	}

	public function renew($data){
		$iuguSubscription = $this->iuguSubscriptionClient->find($data['id']);
		$subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
		if($subscription && $subscription->expires_at != $iuguSubscription->expires_at){
			$this->subscriptionRepository->update([
				'expires_at' => $iuguSubscription->expires_at,
				'status' => Subscription::STATUS_ATIVE
			], $subscription->id);
		}
	}

	public function cancel($subscriptionId){
		$this->subscriptionRepository->pushCriteria(new FindByUserCriteria());
		$subscription = $this->subscriptionRepository->find($subscriptionId);
		$this->iuguSubscriptionClient->suspend($subscription->code);
		$this->subscriptionRepository->update([
			'status' => Subscription::STATUS_INATIVE,
			'canceled_at' => (new Carbon())->format('Y-m-d')
		], $subscription->code);
	}
}