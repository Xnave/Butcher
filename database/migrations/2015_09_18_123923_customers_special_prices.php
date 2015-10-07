<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomersSpecialPrices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers_special_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('customer_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('special_price')->unsigned();

			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');;
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers_special_prices');
	}

}
