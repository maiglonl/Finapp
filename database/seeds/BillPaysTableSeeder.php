<?php

use Illuminate\Database\Seeder;
use Finapp\Repositories\BillPayRepository;

class BillPaysTableSeeder extends Seeder
{
	use \Finapp\Repositories\GetClientsTrait;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$clients = $this->getClients();

		$repository = app(BillPayRepository::class);
		factory(\Finapp\Models\BillPay::class, 200)
			->make()
			->each(function($billPay) use($clients, $repository){
				$client = $clients->random();
				\Landlord::addTenant($client);
				$bankAccount = $client->bankAccounts->random();
				$category = $client->categoryExpenses->random();
				$billPay->client_id = $client->id;
				$billPay->bank_account_id = $bankAccount->id;
				$billPay->category_id = $category->id;
				$repository->create($billPay->toArray());
			});
	}
}
