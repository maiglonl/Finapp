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
        	->each(finction($billReceive) use($clients){
        		$client = $clients->random();
        		$billReceive->client_id = $client->id;
        		$billReceive->save();
        	});
    }
}
