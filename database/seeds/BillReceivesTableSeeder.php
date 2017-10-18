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
		echo("3.1");
        $clients = $this->getClients();

        factory(\Finapp\Models\BillReceive::class, 200)
        	->make()
        	->each(function($billReceive) use($clients){
        		$client = $clients->random();
        		$billReceive->client_id = $client->id;
        		$billReceive->save();
        	});
    }
}
