<?php

namespace Finapp\Repositories;

trait GetClientsTrait{

	private function getClients(){
		/** @var ClientRepository $clientRepository */
		$clientRepository = app(ClientRepository::class);
		$clientRepository->skipPresenter(true);
		return $clientRepository->all();
	}
}