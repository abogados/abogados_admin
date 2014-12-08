<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarColumnaTipoProcesoDeModelos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modelos', function(Blueprint $table)
		{
			$table->dropColumn('tipo_proceso');
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
			$table->string('tipo_proceso')->nullable();
		});
	}

}
