<?php

use Illuminate\Database\Seeder;
use Finapp\Models\BankAccount;
use Finapp\Repositories\BankRepository;

class BankAccountsTableSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		/** @var BankRepository $repository */
		$repository = app(BankRepository::class);
		$repository->skipPresenter(true);
		$banks = $repository->all();
		$max = 15;
		$idDefault = rand(1, $max);

		factory(BankAccount::class, $max)
			->make()
			->each( function($bankAccount) use($banks, $idDefault){
				$bank = $banks->random();
				$bankAccount->bank_id = $bank->id;
				$bankAccount->save();

				if( $idDefault == $bankAccount->id){
					$bankAccount->default = 1;
					$bankAccount->save();
				}
			});
	}
}
