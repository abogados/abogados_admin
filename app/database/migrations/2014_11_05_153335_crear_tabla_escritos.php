<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEscritos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('escritos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('expediente_id')->unsigned();
			$table->string('titulo');
			$table->string('descripcion')->nullable();
			$table->string('cuerpo')->nullable();
			$table->string('estado');
			$table->foreign('expediente_id')
      			->references('id')->on('expedientes')
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
		Schema::drop('escritos');
	}

}
