<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class OrdersController extends Controller {

	public function store()
	{
		$order = new \App\Models\Order(\Input::all());

		//validate
		$file = array('orderer_id' => $order->orderer_id, 'order_finish_date' => $order->order_finish_date);
		$rules = array('orderer_id' => 'required', 'order_finish_date' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
		$validator = \Validator::make($file, $rules);

		if ($validator->fails())
		{
            return \Response::json($validator->messages());
		}

		//try save
		try{
            $order->save();
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}

		\Session::flash('success', 'הזמנה נוצרה בהצלחה');
		return $order->id;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$order = \App\Models\Order::find($id);
		$order->fill(\Input::all());
		$order->save();

		\Session::flash('success', 'ההזמנה עודכנה');
		return \Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$order = \App\Models\Order::findOrFail($id);
		$order->is_valid = false;
        $order->save();

		return 'ההזמנה נמחקה';
	}

    public function deleteOrderItem($id){
        \DB::statement('update butcher.orders_products set is_valid = 0 where id = ' . $id);

        return 'פריט נמחק מההזמנה';
    }

    public function storeOrderItem($id){
        $order = \App\Models\Order::findOrFail($id);

        $product_id = \Input::get('product_id');
        if(in_array($product_id, $order->orderItems()->where('is_valid', '=', '1')->getRelatedIds()))
        {
            \Session::flash('fail', 'פריט זה כבר נמצא בהזמנה');
            \App::abort(502, 'פריט זה כבר נמצא בהזמנה');
        }
        if(is_null(\App\Models\Product::find($product_id)))
        {
            \Session::flash('fail', 'הפריט שנבחר אינו תקין');
            \App::abort(502, 'הפריט שנבחר אינו תקין');
        }

        $is_freeze_allowed = false;
        if(is_null(\Input::get('is_freeze_allowed'))){
            $is_freeze_allowed = true;
        }

        $units = \Input::get('units');
        $amount = \Input::get('amount');
        $weight = \Input::get('weight');
        if($amount == 0)
        {
            $units = 'amount_product_units';
            $amount = 1;
        }
        if(is_numeric($units)){
            $units = \App\Models\Units::find($units)->param_name;
        }
        if(!$weight){
            $weight = 0;
        }


        $order->orderItems()->sync([$product_id => ['is_freeze_allowed' => $is_freeze_allowed,
            $units  => $amount, 'is_valid' => 1, 'weight' => $weight,
            'additional_details' => \Input::get('additionalDetails')] ], false);
        \Session::flash('success', 'פריט הוסף להזמנה');
        //get the id and modify form url
        return \Response::json(\DB::select('select id from butcher.orders_products where product_id = ' . $product_id .
                                                 ' and order_id = ' . $order->id . ' and is_valid = 1'));
    }

    public function show($id){
        $customer = \App\Models\Customer::find($id);
        $orders = \App\Models\Order::with(['orderItems' => function($query){
            $query->select('orders_products.id', 'product_id', 'order_id', 'is_freeze_allowed',
                'amount_product_units', 'amount_kilo', 'amount_packages', 'weight', 'additional_details')->where('is_valid', '=', '1');
        }])->where('orderer_id', $id)->where('is_valid', '=', '1')->where('is_delivered', '=', '0')->get();
        $units = \App\Models\Units::all();
        $products = \App\Models\Product::all();

        $customer->customPrices = $customer->customerSpecialPrices()->select('product_id', 'special_price')->get();
        \JavaScript::put([
            'customers' => [$customer->id => $customer],
            'orders'   => $orders,
            'units'    => $units,
            'products'  => $products
        ]);
        return view('model-views.customerOrders.show');
    }

    public function getOrders($id){
        return \Response::json(\DB::table('orders')->where('orderer_id', $id)->get());
    }

    public function getOrderItems($id){
        return \Response::json(\DB::table('orders_products')->where('order_id', $id)->get());
    }

    public function getProducts(){
        return \Response::json(\App\Models\Product::all());
    }

    public function getUnits(){
        return \Response::json(\App\Models\Units::all());
    }

    public function OrderDeletedItems($id){
        return \Response::json(\DB::table('orders_products')->where('order_id', $id)->where('is_valid', '0')->get());
    }

    public function updateWeight(){
        $weight = \Input::get('weight');
        $details = \Input::get('details');
        \DB::table('orders_products')->where('id', \Input::get('id'))->update(['weight' => $weight, 'additional_details' => $details]);

        return 'משקל עודכן';
    }

    public function doneOrder(){
        \App\Models\Order::find(\Input::get('id'))->update(['is_done' => '1']);

        return 'הזמנה הושלמה';
    }
    public function doneOrderUndo(){
        \App\Models\Order::find(\Input::get('id'))->update(['is_done' => '0', 'is_paid' => '0']);

        return 'ביטול הצליח';
    }

    public function paidOrder(){
        \App\Models\Order::find(\Input::get('id'))->update(['is_done' => '1', 'is_paid' => '1']);

        return 'הזמנה שולמה';
    }
    public function paidOrderUndo(){
        \App\Models\Order::find(\Input::get('id'))->update(['is_paid' => '0']);

        return 'ביטול הצליח';
    }

    public function changeDate(){
        \App\models\Order::find(\Input::get('order_id'))->update(['order_finish_date' => \Input::get('order_finish_date')]);

        return 'תאריך עודכן';
    }

    public function recoverItem(){
        \DB::table('orders_products')->where('id', \Input::get('item_id'))->update(['is_valid' => '1']);

        return 'פריט שוחזר';
    }

    public function openOrders(){
        $units = \App\Models\Units::all();
        $products = \App\Models\Product::all();

        $customers = \App\Models\Customer::all();
        for($i=0; $i < count($customers); $i++){
            $customers[$i]->customPrices =  $customers[$i]->customerSpecialPrices()->select('product_id', 'special_price')->get();
        }
        \JavaScript::put([
            'customers' => $customers,
            'openOrders'   => self::allOrders(),
            'doneNonPaidOrders'   => self::allOrders(true),
            'paidOrders'   => self::allOrders(true, true),
            'units'    => $units,
            'products'  => $products
        ]);
        return view('model-views.customerOrders.openOrders');
    }

    public function allOrders($is_done = false, $is_paid = false){
        $is_done = $is_done? '1' : '0';
        $is_paid = $is_paid? '1' : '0';
        return \App\Models\Order::with(['orderItems' => function($query){
            $query->select('orders_products.id', 'product_id', 'order_id', 'is_freeze_allowed',
                'amount_product_units', 'amount_kilo', 'amount_packages', 'weight', 'additional_details')->where('is_valid', '=', '1');
        }])->where('is_valid', '=', '1')->where('is_done', '=', $is_done)->where('is_paid', '=', $is_paid)->get();
    }

    public function allOpenOrders(){
        return \Response::json(self::allOrders());
    }

    public function allDoneNonPaidOrders(){
        return \Response::json(self::allOrders(true));
    }

    public function allPaidOrders(){
        return \Response::json(self::allOrders(true, true));
    }

    public function undoneOrderItems(){
        return \Response::json(\DB::table('orders_products')->where('is_valid', '=', '1')->where('weight', '>', '0'));
    }
}
