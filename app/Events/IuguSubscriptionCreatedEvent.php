<?php

namespace Finapp\Events;

class IuguSubscriptionCreatedEvent{

	private $iuguSubscription;
	private $userId;
	private $planId;

	/**
	 * Create a new event instance.
	 *
	 * @param $iuguSubscription
	 * @param $iuguSubscriptionOld
	 * @return void
	 */
	public function __construct($iuguSubscription, $userId, $planId){
		$this->iuguSubscription = $iuguSubscription;
		$this->userId = $userId;
		$this->planId = $planId;
	}

	public function getIuguSubscription(){
		return $this->iuguSubscription;
	}

	public function getUserId(){
		return $this->userId;
	}

	public function getPlanId(){
		return $this->planId;
	}
}
