<?php 

namespace Finapp\Http\Controllers\Api;

use Carbon\Carbon;

trait BillControllerTrait {
	public function findToPayToday(){
		$dateStart = new Carbon();
		$dateEnd = $dateStart->copy();
		return $this->repository->getTotalFromPeriod($dateStart, $dateEnd);
	}

	public function findToPayRestOfMonth(){
		$dateStart = (new Carbon())->addDays(1);
		if($dateStart->month != (new Carbon())->month){
			$dateStart->subDays(1);
		}
		$dateEnd = $dateStart->copy()->day($dateStart->daysInMonth);
		return $this->repository->getTotalFromPeriod($dateStart, $dateEnd);
	}
}