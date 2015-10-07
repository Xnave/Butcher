<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		DB::table('customers')->insert(array(
			['id' => 1, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'first_name' =>  'נווה', 'last_name' =>  'עיני', 'phone_number' =>  '052-6595639', 'address' =>  'צפת 13 חולון'],
			['id' => 2, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'first_name' =>  'תומר', 'last_name' =>  'עיני', 'phone_number' =>  '052-6595639', 'address' =>  'צפת 13 חולון']
		));

		DB::table('products')->insert(array(
			['id' => 1, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'name' =>  'שוקיים', 'price' =>  '35'],
			['id' => 2, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'name' =>  'עוף שלם', 'price' =>  '24'],
			['id' => 3, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'name' =>  'בשר טחון', 'price' =>  '70'],
			['id' => 4, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'name' =>  'עוף טחון', 'price' =>  '40']
		));

		DB::table('customers_special_prices')->insert(array(
			['id' => NULL, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'customer_id' =>  1, 'product_id' =>  1, 'special_price' =>  32],
			['id' => NULL, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'customer_id' =>  1, 'product_id' =>  2, 'special_price' =>  22],
			['id' => NULL, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'customer_id' =>  2, 'product_id' =>  3, 'special_price' =>  65],
			['id' => NULL, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'customer_id' =>  2, 'product_id' =>  4, 'special_price' =>  35]
		));

		DB::table('units')->insert(array(
			['id' => 1, 'name' => 'יחידות', 'param_name' => 'amount_product_units'],
			['id' => 2, 'name' => 'קילו', 'param_name' => 'amount_kilo'],
			['id' => 3, 'name' => 'חבילות', 'param_name' => 'amount_packages']
		));
	}

}
