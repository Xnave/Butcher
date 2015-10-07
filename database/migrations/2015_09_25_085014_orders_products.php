<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_products', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('product_id')->unsigned();

			$table->boolean('is_freeze_allowed');
			$table->integer('weight')->nullable();

			$table->integer('amount_product_units')->nullable();
			$table->integer('amount_kilo')->nullable();
			$table->integer('amount_packages')->nullable();

			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products');

			$table->boolean('is_valid')->default(true);
			$table->string('additional_details')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders_products');
	}

}
