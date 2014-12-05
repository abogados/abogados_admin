<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCuerpoEliminarDescripcionEnEscritos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('escritos', function(Blueprint $table)
		{
			$table->dropColumn('descripcion');
			DB::statement('ALTER TABLE `escritos` MODIFY `cuerpo` LONGTEXT NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('escritos', function(Blueprint $table)
		{
			$table->string('descripcion')->nullable();
			DB::statement('ALTER TABLE `escritos` MODIFY `cuerpo` TEXT NULL;');
		});
	}

}
