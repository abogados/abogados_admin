<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarExpedienteIdEnPagos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pagos', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `pagos` MODIFY `expediente_id` INTEGER UNSIGNED NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pagos', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `pagos` MODIFY `expediente_id` INTEGER UNSIGNED;');
		});
	}

}
