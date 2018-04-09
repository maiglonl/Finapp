<?php
namespace Finapp\Iugu;

use Finapp\Models\User;
use Finapp\Models\Plan;
use Finapp\Iugu\IuguCustomerClient;
use Finapp\Iugu\IuguPaymentMethodClient;

class IuguSubscriptionManager{

	private $iuguCustomerClient;
	private $iuguPaymentMethodClient;

	public function __construct(IuguCustomerClient $iuguCustomerClient, IuguPaymentMethodClient $iuguPaymentMethodClient, ){
		$this->iuguCustomerClient = $iuguCustomerClient;
		$this->iuguPaymentMethodClient = $iuguPaymentMethodClient;
	}

	public function create(User $user, Plan $plan, $date){
		$client = $user->client;
		$customer = $this->makeCustomer($client);
		$customerId = $customer == null ? $client->code : $customer['id'];
		$this->makePaymentMethod($customerId, $data['payment_type'], $data['token_payment']);
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