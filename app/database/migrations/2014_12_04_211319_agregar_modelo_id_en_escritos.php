<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarModeloIdEnEscritos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('escritos', function(Blueprint $table)
		{
			$table->integer('modelo_id')->unsigned()->nullable();
			$table->foreign('modelo_id')
      			->references('id')->on('modelos')
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
		Schema::table('escritos', function(Blueprint $table)
		{
			$table->dropForeign('escritos_modelo_id_foreign');
			$table->dropColumn('modelo_id');
		});
	}

}
