<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarTextoLongtextToModelos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modelos', function(Blueprint $table)
		{
			$table->longText('texto')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modelos', function(Blueprint $table)
		{
			$table->dropColumn('texto');
		});
	}

}
