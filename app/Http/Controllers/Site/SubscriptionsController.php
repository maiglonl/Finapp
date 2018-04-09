<?php

namespace Finapp\Http\Controllers\Site;

use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Repositories\PlanRepository;
use Finapp\Http\Requests\SubscriptionCreateRequest;
use Finapp\Iugu\IuguSubscriptionManager;

class SubscriptionsController extends Controller{

	private $planRepository;
	private $iuguSubscriptionManager;

	public function __construct(PlanRepository $planRepository, IuguSubscriptionManager $iuguSubscriptionManager){
		$this->planRepository = $planRepository;
		$this->iuguSubscriptionManager = $iuguSubscriptionManager;
	}

	public function create(){
		$plan = $this->planRepository->all()->first();
		return view('site.subscriptions.create', compact('plan'));
	}

	public function store(SubscriptionCreateRequest $request){
		$plan = $this->planRepository->all()->first();
		$this->iuguSubscriptionManager->create(
			\Auth::user(), $plan, $request->all()
		);
	}
}
