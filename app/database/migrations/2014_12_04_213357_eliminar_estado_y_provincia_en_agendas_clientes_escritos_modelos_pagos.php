<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarEstadoYProvinciaEnAgendasClientesEscritosModelosPagos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agendas', function(Blueprint $table)
		{
			$table->dropColumn('estado');
		});

		Schema::table('clientes', function(Blueprint $table)
		{
			$table->dropColumn('estado');
			$table->dropColumn('provincia');
		});

		Schema::table('escritos', function(Blueprint $table)
		{
			$table->dropColumn('estado');
		});

		Schema::table('modelos', function(Blueprint $table)
		{
			$table->dropColumn('estado');
		});

		Schema::table('pagos', function(Blueprint $table)
		{
			$table->dropColumn('estado');
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
			$table->string('estado')->nullable();
		});

		Schema::table('clientes', function(Blueprint $table)
		{
			$table->string('estado')->nullable();
			$table->string('provincia')->nullable();
		});

		Schema::table('escritos', function(Blueprint $table)
		{
			$table->string('estado')->nullable();
		});

		Schema::table('modelos', function(Blueprint $table)
		{
			$table->string('estado')->nullable();
		});

		Schema::table('pagos', function(Blueprint $table)
		{
			$table->string('estado')->nullable();
		});
	}

}
