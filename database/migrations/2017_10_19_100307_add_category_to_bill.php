<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
	{
		Schema::table('bill_receives', function(Blueprint $table) {
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('category_revenues');
		});
		Schema::table('bill_pays', function(Blueprint $table) {
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('category_expenses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('bill_receives', function(Blueprint $table) {
			$table->dropForeign('bill_receives_category_id_foreign');
			$table->dropColumn('category_id');
		});
		Schema::table('bill_pays', function(Blueprint $table) {
			$table->dropForeign('bill_pays_category_id_foreign');
			$table->dropColumn('category_id');
		});
	}
}
