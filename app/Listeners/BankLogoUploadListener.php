<?php

namespace Finapp\Listeners;

use Finapp\Events\BankStoredEvent;
use Finapp\Models\Bank;
use Finapp\Repositories\BankRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankLogoUploadListener{
	private $repository;
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct(BankRepository $repository){
		$this->repository = $repository;
	}

	/**
	 * Handle the event.
	 *
	 * @param  BankStoredEvent  $event
	 * @return void
	 */
	public function handle(BankStoredEvent $event){
		$bank = $event->getBank();
		$logo = $event->getLogo();
		if($logo){
			$name = $bank->created_at != $bank->updated_at ? $bank->logo : md5(time().$bank->name).'.'.$logo->guessExtension();
			$dest = Bank::logosDir();

			$result = \Storage::disk('public')->putFileAs($dest, $logo, $name);

			if($result && $bank->created_at == $bank->updated_at){
				$this->repository->update(['logo' => $name], $bank->id);
			}
		}
	}
}
