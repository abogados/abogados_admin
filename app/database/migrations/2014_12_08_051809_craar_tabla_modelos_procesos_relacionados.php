<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraarTablaModelosProcesosRelacionados extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modelos_procesos_relacionados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('modelos_proceso_id')->unsigned();
			$table->integer('modelo_id')->unsigned();
			$table->foreign('modelo_id')
      			->references('id')->on('modelos')
      			->onDelete('cascade');
      		$table->foreign('modelos_proceso_id')
      			->references('id')->on('modelos_procesos')
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
		Schema::drop('modelos_procesos_relacionados');
	}

}
