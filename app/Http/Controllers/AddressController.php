<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AddressController extends Controller {

	public function validateAddress()
	{
		$address = \Input::get('address');

		$response = \Geocode::make()->address($address);

		if ($response) {
			return \Response::json(array('lat' => $response->latitude(), 'lng' => $response->longitude()));
		}
	}

}
