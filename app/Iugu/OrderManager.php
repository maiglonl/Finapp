<?php
namespace Finapp\Iugu;

use Finapp\Repositories\SubscriptionRepository;
use Finapp\Repositories\OrderRepository;
use Finapp\Models\Order;
use Carbon\Carbon;

class OrderManager{

	private $iuguSubscriptionClient;
	private $iuguInvoiceClient;
	private $subscriptionRepository;

	public function __construct(
		IuguSubscriptionClient $iuguSubscriptionClient,
		IuguInvoiceClient $iuguInvoiceClient,
		SubscriptionRepository $subscriptionRepository,
		OrderRepository $orderRepository
	){
		$this->iuguSubscriptionClient = $iuguSubscriptionClient;
		$this->iuguInvoiceClient = $iuguInvoiceClient;
		$this->subscriptionRepository = $subscriptionRepository;
		$this->orderRepository = $orderRepository;
	}

	public function create($data){
		$iuguSubscription = $this->iuguSubscriptionClient->find($data['subscription_id']);
		$subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
		if($subscription){
			$invoice = $iuguSubscription->recent_invoices[0];
			$total = $this->getValue($invoice->total);
			$this->orderRepository->create([
				'date_due' => $invoice->due_date,
				'code' => $invoice->id,
				'subscription_id' => $subscription->id,
				'value' => $total,
				'status' => $invoice->status == 'paid' ? Order::STATUS_PAID : Order::STATUS_PENDING,
				'payment_date' => $invoice->status == 'paid' ? (new Carbon())->format('Y-m-d') : null,
				'payment_url' => $invoice->secure_url
			]);
		}
	}

	public function paid(array $data){
		$invoice = $this->iuguInvoiceClient->find($data['id']);
		$order = $this->orderRepository->findByField('code', $invoice->id)->first();
		if($order && $order->status != Order::STATUS_PAID){
			$this->orderRepository->update([
				'status' => Order::STATUS_PAID,
				'payment_date' => new date('Y-m-d')
			], $order->id);
		}
	}

	protected function getValue($value){
		$value = str_replace('R$', '', $value);
		$value = str_replace(' ', '', $value);
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		return $value;
	}
}