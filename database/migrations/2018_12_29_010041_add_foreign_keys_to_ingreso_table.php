<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIngresoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ingreso', function(Blueprint $table)
		{
			$table->foreign('cliente_id_cliente', 'fk_pago_cliente1')->references('id_cliente')->on('cliente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ingreso', function(Blueprint $table)
		{
			$table->dropForeign('fk_pago_cliente1');
		});
	}

}
