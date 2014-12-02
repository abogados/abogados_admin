<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarEstCivilLocalidadLegajoSexoTelCelProfIngresoToUsuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('usuarios', function(Blueprint $table)
		{
			$table->string('legajo');
			$table->string('estado_civil');
			$table->string('localidad');
			$table->string('sexo');
			$table->string('telefono');
			$table->string('celular');
			$table->string('profesion');
			$table->string('fecha_ingreso');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('usuarios', function(Blueprint $table)
		{
			$table->dropColumn('legajo');
			$table->dropColumn('estado_civil');
			$table->dropColumn('localidad');
			$table->dropColumn('sexo');
			$table->dropColumn('telefono');
			$table->dropColumn('celular');
			$table->dropColumn('profesion');
			$table->dropColumn('fecha_ingreso');
		});
	}


}
