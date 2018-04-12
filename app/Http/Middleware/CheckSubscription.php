<?php

namespace Finapp\Http\Middleware;

use Closure;
use Finapp\Criteria\FindSubscriptionByUserClientCriteria;
use Finapp\Repositories\SubscriptionRepository;
use Finapp\Models\Subscription;
use Carbon\Carbon;

class CheckSubscription
{

	private $subscriptionRepository;

	public function __construct(SubscriptionRepository $subscriptionRepository){
		$this->subscriptionRepository = $subscriptionRepository;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $beforeOrAfter = 'before'){
		error_log($beforeOrAfter);
		if($beforeOrAfter == 'before'){
			$responseSubscriptionExpired = $this->responseSubscriptionExpired();
			if($responseSubscriptionExpired){
				return $responseSubscriptionExpired;
			}
			return $next($request);
		}else{
			$response = $next($request);
			$responseSubscriptionExpired = $this->responseSubscriptionExpired();
			return !$responseSubscriptionExpired ? $response : $responseSubscriptionExpired;
		}
	}

	protected function responseSubscriptionExpired(){
		$subscription = $this->getSubscription();
		if($subscription){
			$result = $this->isExpired($subscription);
			if($result){
				return response()->json([
					'error' => 'subscription_expired',
					'message' => 'Assinatura Expirada'
				], 403);
			}
		}else{
			return response()->json([
				'error' => 'subscription_not_found',
				'message' => 'Cliente sem assinatura contratada'
			], 400);
		}
		return false;
	}

	protected function getSubscription(){
		$client = \Auth::guard('api')->user()->client;
		$subscription = $this->subscriptionRepository->getByCriteria(new FindSubscriptionByUserClientCriteria($client->id))->first();
		return $subscription;
	}

	protected function isExpired($subscription){
		if(!$subscription->expires_at || $subscription->status == Subscription::STATUS_INATIVE || $subscription->canceled_at != null){
			return true;
		}
		$expiresAt = new Carbon($subscription->expires_at);
		return $expiresAt->lt(new Carbon()) ? true : false;
	}
}
