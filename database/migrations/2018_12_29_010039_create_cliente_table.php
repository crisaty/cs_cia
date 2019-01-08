<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente', function(Blueprint $table)
		{
			$table->integer('id_cliente', true);
			$table->string('nom_cliente', 45)->unique('nom_cliente_UNIQUE');
			$table->date('fec_ingreso');
			$table->string('mail', 100);
			$table->string('telefono', 45)->nullable();
			$table->boolean('estado');
			$table->integer('empresa_id_empresa')->index('fk_cliente_empresa_idx');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente');
	}

}
