<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    public static $snakeAttributes = false;

    protected $nullable = ['order_finish_date'];
    protected $fillable = ['orderer_id', 'is_done', 'is_paid', 'order_finish_date', 'amount_product_units', 'amount_kilo', 'amount_packages'];

    public function orderItems(){
        return $this->belongsToMany('App\Models\Product', 'orders_products', 'order_id', 'product_id')
            ->withPivot('id', 'is_freeze_allowed', 'amount_product_units', 'amount_kilo', 'amount_packages', 'weight', 'additional_details');

    }

}
