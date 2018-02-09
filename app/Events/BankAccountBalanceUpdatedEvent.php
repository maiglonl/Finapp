<?php

namespace Finapp\Events;

use Finapp\Models\BankAccount;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class BankAccountBalanceUpdatedEvent implements ShouldBroadcast {

	public $bankAccount;

	/**
	 * Create a new event instance.
	 */
	public function __construct(BankAccount $bankAccount){
		$this->bankAccount = $bankAccount;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn(){
		error_log("client.{$this->bankAccount->client_id}");

		return new PrivateChannel("client.".$this->bankAccount->client_id);
	}

}
