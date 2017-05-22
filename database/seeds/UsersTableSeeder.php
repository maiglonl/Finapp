<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(\Finapp\User::class, 1)
			->states('admin')
			->create([
				'name' => 'Maiglon Lubacheuski',
				'email' => 'admin@user.com'
			]
		);

		factory(\Finapp\User::class, 1)
			->create([
				'email' => 'client@user.com'
			]
		);
	}
}
