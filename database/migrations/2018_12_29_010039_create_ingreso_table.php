<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngresoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingreso', function(Blueprint $table)
		{
			$table->integer('id_pago', true);
			$table->decimal('total_pago', 11, 3);
			$table->decimal('total_ingreso', 11, 3);
			$table->string('tipo_pago', 45)->nullable();
			$table->date('fecha_pago')->nullable();
			$table->string('cod_pago', 45)->nullable();
			$table->integer('cliente_id_cliente')->index('fk_pago_cliente1_idx');
			$table->boolean('estado');
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
		Schema::drop('ingreso');
	}

}
