<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarColumnaMontoEnPagos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pagos', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `pagos` MODIFY `monto` DECIMAL(11,2);');
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
			DB::statement('ALTER TABLE `pagos` MODIFY `monto` VARCHAR(255) NULL;');
		});
	}

}
