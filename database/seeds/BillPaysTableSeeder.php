<?php

use Illuminate\Database\Seeder;

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

        factory(\Finapp\Models\BillPay::class, 200)
        	->make()
        	->each(finction($billPay) use($clients){
        		$client = $clients->random();
        		$billPay->client_id = $client->id;
        		$billPay->save();
        	});
    }
}
