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
		echo("3.1");
        $clients = $this->getClients();

        factory(\Finapp\Models\BillPay::class, 200)
        	->make()
        	->each(function($billPay) use($clients){
        		$client = $clients->random();
        		$billPay->client_id = $client->id;
        		$billPay->save();
        	});
    }
}
