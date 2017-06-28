<?php

use Illuminate\Database\Seeder;
use Finapp\Models\BankAccount;
use Finapp\Repositories\BankRepository;
use Finapp\Repositories\ClientRepository;

class BankAccountsTableSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		
		$banks = $this->getBanks();
		$clients = $this->getClients();
		$max = 50;
		$idDefault = rand(1, $max);

		factory(BankAccount::class, $max)
			->make()
			->each( function($bankAccount) use($banks, $idDefault, $clients){
				$bank = $banks->random();
				$client = $clients->random();

				$bankAccount->bank_id = $bank->id;
				$bankAccount->client_id = $client->id;
				$bankAccount->save();

				if( $idDefault == $bankAccount->id){
					$bankAccount->default = 1;
					$bankAccount->save();
				}
			});
	}

	private function getBanks(){
		/** @var BankRepository $bankRepository */
		$bankRepository = app(BankRepository::class);
		$bankRepository->skipPresenter(true);
		return $bankRepository->all();
	}

	private function getClients(){
		/** @var ClientRepository $clientRepository */
		$clientRepository = app(ClientRepository::class);
		$clientRepository->skipPresenter(true);
		return $clientRepository->all();
	}
}
