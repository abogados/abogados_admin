<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('apellido');
			$table->string('dni',8);
			$table->string('fecha_nacimiento',10);
			$table->string('user');
			$table->string('password');
			$table->string('perfil');
			$table->string('email');
			$table->string('domicilio');
			$table->string('password_temp');
			$table->string('codigo');
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('usuarios');
	}

}
