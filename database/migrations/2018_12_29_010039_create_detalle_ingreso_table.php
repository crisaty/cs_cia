<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleIngresoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_ingreso', function(Blueprint $table)
		{
			$table->integer('id_detalle_orden')->primary();
			$table->integer('cantidad');
			$table->decimal('precio_venta', 11, 3);
			$table->integer('producto_id_producto')->index('fk_detalle_orden_producto1_idx');
			$table->integer('pago_id_pago')->index('fk_detalle_orden_pago1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_ingreso');
	}

}
