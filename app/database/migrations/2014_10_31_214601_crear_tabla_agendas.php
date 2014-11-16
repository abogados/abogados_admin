<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAgendas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->string('tipo_evento');
			$table->string('fecha');
			$table->string('hora_inicio');
			$table->string('hora_fin');
			$table->string('fecha_alarma');
			$table->string('hora_alarma');
			$table->string('observaciones');
			$table->string('estado');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendas');
	}

}
