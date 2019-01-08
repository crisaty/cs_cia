<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cliente', function(Blueprint $table)
		{
			$table->foreign('empresa_id_empresa', 'fk_cliente_empresa')->references('id_empresa')->on('empresa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cliente', function(Blueprint $table)
		{
			$table->dropForeign('fk_cliente_empresa');
		});
	}

}
