<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_soporte', function(Blueprint $table)
		{
			$table->integer('id_detalle_soporte', true);
			$table->integer('producto_id_producto')->index('fk_detalle_orden_producto1_idx');
			$table->integer('soporte_id_soporte')->index('fk_detalle_s_soporte1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_soporte');
	}

}
