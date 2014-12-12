<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarTituloModificarRutaArchivoEnEscritosImportaciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('escritos_importaciones', function(Blueprint $table)
		{
			$table->dropColumn('ruta_archivo');
			$table->string('nombre_archivo');
			$table->dropColumn('titulo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('escritos_importaciones', function(Blueprint $table)
		{
			$table->dropColumn('nombre_archivo');
			$table->string('ruta_archivo')->nullable();
			$table->string('titulo')->nullable();
		});
	}

}
