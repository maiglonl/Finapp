<?php

namespace Finapp\Http\Controllers\Site;

use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Repositories\PlanRepository;

class SubscriptionsController extends Controller{

	public function __construct(PlanRepository $planRepository){
		$this->planRepository = $planRepository;
	}

	public function create(){
		$plan = $this->planRepository->all()->first();
		return view('site.subscriptions.create', compact('plan'));
	}

	public function store(){
		
	}
}
