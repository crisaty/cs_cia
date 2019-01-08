<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('producto', function(Blueprint $table)
		{
			$table->integer('id_producto', true);
			$table->string('nom_producto', 45);
			$table->decimal('precio_costo', 11, 3);
			$table->decimal('precio_venta', 11, 3);
			$table->boolean('estado');
			$table->date('fecha_exp')->nullable();
			$table->text('info', 65535)->nullable();
			$table->integer('tipo_producto_id_tipoproducto')->unsigned()->index('fk_producto_tipo_producto1_idx');
			$table->integer('cliente_id_cliente')->index('fk_producto_cliente1_idx');
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
		Schema::drop('producto');
	}

}
