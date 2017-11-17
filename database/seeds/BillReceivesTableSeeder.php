<?php

use Illuminate\Database\Seeder;

class BillReceivesTableSeeder extends Seeder
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

        factory(\Finapp\Models\BillReceive::class, 200)
        	->make()
        	->each(function($billReceive) use($clients){
				$client = $clients->random();
				$bankAccount = $client->bankAccounts->random();
				$category = $client->categoryRevenues->random();
				$billReceive->client_id = $client->id;
				$billReceive->bank_account_id = $bankAccount->id;
				$billReceive->category_id = $category->id;
				$billReceive->save();
			});
    }
}
