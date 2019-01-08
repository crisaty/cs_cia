<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('soporte', function(Blueprint $table)
		{
			$table->foreign('cliente_id_cliente', 'fk_soporte_cliente1')->references('id_cliente')->on('cliente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('soporte', function(Blueprint $table)
		{
			$table->dropForeign('fk_soporte_cliente1');
		});
	}

}
