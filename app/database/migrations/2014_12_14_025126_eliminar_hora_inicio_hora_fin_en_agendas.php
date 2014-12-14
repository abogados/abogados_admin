<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarHoraInicioHoraFinEnAgendas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function(Blueprint $table)
		{
			$table->dropColumn('hora_inicio');
			$table->dropColumn('hora_fin');
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
			$table->string('hora_inicio')->nullable();
			$table->string('hora_fin')->nullable();
		});
	}

}
