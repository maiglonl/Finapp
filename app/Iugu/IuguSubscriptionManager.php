<?php
namespace Finapp\Iugu;

use Finapp\Models\Client;
use Finapp\Models\User;
use Finapp\Models\Plan;
use Finapp\Iugu\IuguCustomerClient;
use Finapp\Iugu\IuguPaymentMethodClient;
use Finapp\Repositories\SubscriptionRepository;
use Finapp\Models\Subscription;

class IuguSubscriptionManager{

	private $iuguCustomerClient;
	private $iuguPaymentMethodClient;
	private $iuguSubscriptionClient;
	private $subscriptionRepository;

	public function __construct(
		IuguCustomerClient $iuguCustomerClient, 
		IuguPaymentMethodClient $iuguPaymentMethodClient, 
		IuguSubscriptionClient $iuguSubscriptionClient
	){
		$this->iuguCustomerClient = $iuguCustomerClient;
		$this->iuguPaymentMethodClient = $iuguPaymentMethodClient;
		$this->iuguSubscriptionClient = $iuguSubscriptionClient;
	}

	public function renew($data){
		$iuguSubscription = $this->iuguSubscriptionClient->find($data['id']);
		$subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
		$result = $subscription;
		if ($subscription && $subscription->expires_at != $iuguSubscription->expires_at) {
			$this->subscriptionRepository->update([
				'expires_at' => $iuguSubscription->expires_at,
				'status' => Subscription::STATUS_ATIVE
			], $subscription->id);
		}
	}

	public function create(User $user, Plan $plan, $data){
		$client = $user->client;
		$customer = $this->makeCustomer($client);
		$customerId = $customer == null ? $client->code : $customer['id'];
		$this->makePaymentMethod($customerId, $data['payment_type'], $data['token_payment']);

		$this->iuguSubscriptionClient->create([
			'user_id' => $user->id,
			'plan_id' => $plan->id,
			'plan_identifier' => $plan->code,
			'customer_id' => $customerId,
			'payment_type' => $data['payment_type']
		]);

	}

	protected function makeCustomer(Client $client){
		if($client->code == null){
			return $this->iuguCustomerClient->create($client->toArray());
		}
		return null;
	}

	protected function makePaymentMethod($id, $type, $token){
		if($type == 'credit_card'){
			return $this->iuguPaymentMethodClient->create([
				'customer_id' => $id,
				'token' => $token
			]);
		}
		return null;
	}
}