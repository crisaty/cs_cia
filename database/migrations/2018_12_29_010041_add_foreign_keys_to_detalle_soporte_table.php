<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_soporte', function(Blueprint $table)
		{
			$table->foreign('producto_id_producto', 'fk_detalle_orden_producto10')->references('id_producto')->on('producto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('soporte_id_soporte', 'fk_detalle_s_soporte1')->references('id_soporte')->on('soporte')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_soporte', function(Blueprint $table)
		{
			$table->dropForeign('fk_detalle_orden_producto10');
			$table->dropForeign('fk_detalle_s_soporte1');
		});
	}

}
