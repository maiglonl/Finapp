<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankLogoDefault extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		$logo = new \Illuminate\Http\UploadedFile(
			storage_path('app/files/banks/logos/default.png'),
			'default.png'
		);
		$name = env('BANK_LOGO_DEFAULT');
		$dest = \Finapp\Models\Bank::logosDir();

		\Storage::disk('public')->putFileAs($dest, $logo, $name);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		$name = env('BANK_LOGO_DEFAULT');
		$dest = \Finapp\Models\Bank::logosDir();
		\Storage::disk('public')->delete($dest.'/'.$name);
	}
}
