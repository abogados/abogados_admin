<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaModelosCodigosRelacionados extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modelos_codigos_relacionados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo');
			$table->string('descripcion');
			$table->string('nombre_modelo');
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
		Schema::drop('modelos_codigos_relacionados');
	}

}
