<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarUsuarioIdEnAgendas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function(Blueprint $table)
		{
			$table->integer('usuario_id')->unsigned()->nullable();
			$table->foreign('usuario_id')
      			->references('id')->on('usuarios')
      			->onDelete('cascade');
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
			$table->dropForeign('agendas_usuario_id_foreign');
			$table->dropColumn('usuario_id');
		});
	}

}
