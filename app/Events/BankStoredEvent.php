<?php

namespace Finapp\Events;

use Finapp\Models\Bank;
use Illuminate\Http\UploadedFile;

class BankStoredEvent{

	private $bank;
	private $logo;

	/**
	 * Create a new event instance.
	 *
	 * @param Bank $bank
	 * @param UploadedFile $logo
	 * @return void
	 */
	public function __construct(Bank $bank, UploadedFile $logo = null){
		$this->bank = $bank;
		$this->logo = $logo;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn(){
		return new PrivateChannel('channel-name');
	}

	public function getBank(){
		return $this->bank;
	}
	public function getLogo(){
		return $this->logo;
	}
}
