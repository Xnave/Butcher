<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class CustomersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$customers = \App\Models\Customer::all();

		return view('model-views.index')->with(array('modelName' => 'customers', 'models' => $customers, 'modelDetails' => 'customers.details'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('model-views.create')->with(array('modelName' => 'customers', 'modelHebrewName' => 'לקוח'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$customer = new \App\Models\Customer(\Input::all());

		//validate
		$file = array('first_name' => $customer->first_name, 'last_name' => $customer->last_name);
		$rules = array('first_name' => 'required', 'last_name' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
		$validator = \Validator::make($file, $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		//try save
		try{
			$customer->save();
		}
		catch(\Exception $e)
		{
			return \Redirect::back()->withInput()->withErrors(new MessageBag(array($e->getMessage())));
		}

		\Session::flash('success', 'לקוח הוסף בהצלחה');
		return \Redirect::back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$customer = \App\Models\Customer::findOrFail($id);
		$customerPrices = $customer->customerSpecialPrices()->get();
		return view('model-views.customers.show')->with(['customer' => $customer, 'customerPrices' => $customerPrices]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = \App\Models\Customer::findOrFail($id);

		return view('model-views.edit')->with(array('modelName' => 'customers', 'model' => $customer, 'modelHebrewName' => 'לקוח'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$customer = \App\Models\Customer::find($id);
		$customer->fill(\Input::all());
		$customer->save();

		\Session::flash('success', 'לקוח שונה בהצלחה');
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
		$customer = \App\Models\Customer::findOrFail($id);
		$customer->delete();

		\Session::flash('success', 'לקוח נמחק בהצלחה');

        if(\Input::has('redirectBack') && \Input::get('redirectBack')){
            return \Redirect::back();
        }
        else{
            return \Redirect::to('/');
        }
	}

    public function deleteSpecialPrice($id){
        \DB::statement('delete from butcher.customers_special_prices where id = ' . $id);

        \Session::flash('success', 'מחיר מיוחד נמחק בהצלחה');
        return \Redirect::back()->with('success', 'מחיר מיוחד נמחק בהצלחה');
    }

    public function storeSpecialPrice($id){
        $customer = \App\Models\Customer::findOrFail($id);

        if(in_array(\Input::get('product_id'), $customer->customerSpecialPrices()->getRelatedIds()))
        {
            \Session::flash('fail', 'מחיר מיוחד למוצר כבר קיים');
            return \Redirect::back();
        }

        $customer->customerSpecialPrices()->sync([\Input::get('product_id') => ['special_price' => \Input::get('specialPrice')]], false);
        \Session::flash('success', 'מחיר מיוחד עודכן בהצלחה');
        return \Redirect::back();
    }
}
