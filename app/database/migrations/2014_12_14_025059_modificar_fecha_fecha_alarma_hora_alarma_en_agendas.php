<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarFechaFechaAlarmaHoraAlarmaEnAgendas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `agendas` MODIFY `fecha` DATE;');
			DB::statement('ALTER TABLE `agendas` MODIFY `fecha_alarma` DATE;');
			DB::statement('ALTER TABLE `agendas` MODIFY `hora_alarma` TIME;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agendas', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `agendas` MODIFY `fecha` VARCHAR(255);');
			DB::statement('ALTER TABLE `agendas` MODIFY `fecha_alarma` VARCHAR(255);');
			DB::statement('ALTER TABLE `agendas` MODIFY `hora_alarma` VARCHAR(255);');
		});
	}

}
