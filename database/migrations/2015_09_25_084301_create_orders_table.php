<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('orderer_id')->unsigned();
			$table->timestamp('order_date')->default(date('d/m/y H:i:s'));
			$table->timestamp('order_finish_date')->nullable();
			$table->boolean('is_done')->default(false);
			$table->boolean('is_paid')->default(false);

			$table->foreign('orderer_id')->references('id')->on('customers');
			$table->boolean('is_valid')->default(true);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
