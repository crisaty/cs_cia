<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProductoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('producto', function(Blueprint $table)
		{
			$table->foreign('cliente_id_cliente', 'fk_producto_cliente1')->references('id_cliente')->on('cliente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tipo_producto_id_tipoproducto', 'fk_producto_tipo_producto1')->references('id_tipoproducto')->on('tipo_producto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('producto', function(Blueprint $table)
		{
			$table->dropForeign('fk_producto_cliente1');
			$table->dropForeign('fk_producto_tipo_producto1');
		});
	}

}
