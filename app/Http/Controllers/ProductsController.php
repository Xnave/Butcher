<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProductsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = \App\Models\Product::all();

		return view('model-views.index')->with(array('modelName' => 'products', 'models' => $products, 'modelDetails' => 'products.details'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('model-views.create')->with(array('modelName' => 'products', 'modelHebrewName' => 'מוצר'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$product = new \App\Models\Product(\Input::all());

		//validate
		$file = array('name' => $product->name, 'price' => $product->price);
		$rules = array('name' => 'required', 'price' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
		$validator = \Validator::make($file, $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		//try save
		try{
			$product->save();
		}
		catch(\Exception $e)
		{
			return \Redirect::back()->withInput()->withErrors(new MessageBag(array($e->getMessage())));
		}

		\Session::flash('success', 'מוצר הוסף בהצלחה');
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = \App\Models\Product::findOrFail($id);

		return view('model-views.edit')->with(array('modelName' => 'products', 'model' => $product, 'modelHebrewName' => 'מוצר'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = \App\Models\Product::find($id);
		$product->fill(\Input::all());
		$product->save();

		\Session::flash('success', 'מוצר שונה בהצלחה');
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
		$product = \App\Models\Product::findOrFail($id);
		$product->delete();

		\Session::flash('success', 'מוצר נמחק בהצלחה');
		return \Redirect::back();
	}

}
