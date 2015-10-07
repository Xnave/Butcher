<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $fillable = ['first_name', 'last_name', 'address', 'phone_number'];
    protected $nullable = ['address', 'phone_number'];

    public function customerSpecialPrices(){
        return $this->belongsToMany('App\Models\Product', 'customers_special_prices', 'customer_id', 'product_id')->withPivot('id', 'special_price');
    }

}
