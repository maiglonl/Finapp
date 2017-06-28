<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		factory(\Finapp\Models\Client::class, 5)->create();
	}
}
