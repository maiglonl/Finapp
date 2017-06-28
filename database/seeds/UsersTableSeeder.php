<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder{
    
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		$repository = app(\Finapp\Repositories\ClientRepository::class);
		$clients = $repository->all();

		factory(\Finapp\Models\User::class, 1)
			->states('admin')
			->create([
				'name' => 'Maiglon Lubacheuski',
				'email' => 'admin@user.com'
			]
		);
		foreach(range(1,50) as $value){
			factory(\Finapp\Models\User::class, 1)
				->create([
					'name' => "Cliente $value",
					'email' => "client$value@user.com"
				]
			)->each(function($user) use($clients){
				$client = $clients->random();
				$user->client()->associate($client);
				$user->save();
			});
		}
	}
}
