<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleIngresoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_ingreso', function(Blueprint $table)
		{
			$table->foreign('pago_id_pago', 'fk_detalle_orden_pago1')->references('id_pago')->on('ingreso')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('producto_id_producto', 'fk_detalle_orden_producto1')->references('id_producto')->on('producto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_ingreso', function(Blueprint $table)
		{
			$table->dropForeign('fk_detalle_orden_pago1');
			$table->dropForeign('fk_detalle_orden_producto1');
		});
	}

}
