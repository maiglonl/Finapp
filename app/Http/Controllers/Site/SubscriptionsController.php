<?php

namespace Finapp\Http\Controllers\Site;

use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Repositories\PlanRepository;
use Finapp\Http\Requests\SubscriptionCreateRequest;
use Finapp\Iugu\IuguSubscriptionManager;
use Finapp\Iugu\Exceptions\IuguCustomerException;
use Finapp\Iugu\Exceptions\IuguPaymentMethodException;
use Finapp\Iugu\Exceptions\IuguSubscriptionException;

class SubscriptionsController extends Controller{

	private $planRepository;
	private $iuguSubscriptionManager;

	public function __construct(PlanRepository $planRepository, IuguSubscriptionManager $iuguSubscriptionManager){
		$this->middleware('auth');
		$this->planRepository = $planRepository;
		$this->iuguSubscriptionManager = $iuguSubscriptionManager;
	}

	public function create(){
		$plan = $this->planRepository->all()->first();
		return view('site.subscriptions.create', compact('plan'));
	}

	public function store(SubscriptionCreateRequest $request){
		$plan = $this->planRepository->all()->first();
		try{
			$this->iuguSubscriptionManager->create(
				\Auth::user(), $plan, $request->all()
			);
		}catch(AbstractIuguException $exception){
			$request->session()->flash('error', $this->getMessageException($exception));
			return redirect()->route('site.subscriptions.create');
		}
		return redirect()->route('site.subscriptions.successfully');
	}

	protected function getMessageException($exception){
		if($exception instanceof IuguCustomerException){
			return 'Erro ao processar cliente. Contate o atendimento para mais detalhes.';
		}else if($exception instanceof IuguPaymentMethodException){
			return 'Erro ao salvar método de pagamento. Contate o atendimento para mais detalhes.';
		}else if($exception instanceof IuguSubscriptionException){
			return 'Erro ao processar assinatura. Contate o atendimento para mais detalhes.';
		}
	}

	public function successfully(){
		return view('site.subscriptions.successfully');
	}
}
