<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaExpedientes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expedientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->string('numero');
			$table->string('caratula');
			$table->string('juzgado');
			$table->string('estado');
			$table->string('fecha_inicio');
			$table->string('fecha_presentacion');
			$table->string('fecha_finalizacion');
			$table->string('tipo_proceso');
			$table->string('pagos');
			$table->foreign('cliente_id')
      			->references('id')->on('clientes')
      			->onDelete('cascade');
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
		Schema::drop('expedientes');
	}

}
