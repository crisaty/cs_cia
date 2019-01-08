<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soporte', function(Blueprint $table)
		{
			$table->integer('id_soporte', true);
			$table->date('fecha');
			$table->dateTime('hora');
			$table->string('titulo', 45);
			$table->decimal('costo', 11, 3);
			$table->text('info', 65535)->nullable();
			$table->boolean('estado');
			$table->integer('cliente_id_cliente')->index('fk_soporte_cliente1_idx');
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
		Schema::drop('soporte');
	}

}
