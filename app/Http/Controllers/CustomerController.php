<?php namespace App\Http\Controllers;

use Hash;
use Response;
use App\Customer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {

	// customer login.
	public function login(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required'
		]);

		$result = array();
		$result["error"] = true;

		if($validator->fails()) {
			// parameter is missing.
			$result["error_message"] = 'Some credentials are missing. Please try again !';
			return Response::json($result);
		} else {
			$customer = Customer::where('username', '=', $request->input('username'))->first();
			if(is_null($customer)) {
				// customer not found, invalid username.
				$result["error_message"] = 'Username not found';
				return Response::json($result);
			}
			if(Hash::check($request->input('password'), $customer->password)) {
				// credential is correct, return data of customer and unique_id.
				$result["error"] = false;
				$result["user"]["id"] = $customer->id;
				$result["user"]["unique_id"] = $customer->unique_id;
				$result["user"]["username"] = $customer->username;
				$result["user"]["firstname"] = $customer->firstname;
				$result["user"]["lastname"] = $customer->lastname;
				$result["user"]["email"] = $customer->email;
				$result["user"]["phone_number"] = $customer->phone_number;
				return Response::json($result);
			}
			// password not match, return fail.
			$result["error_message"] = 'Credentials is wrong. Please try agian !';
			return Response::json($result);
		}

	}

	// Register new customer.
	public function store(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'username' => 'required|unique:customers|min:6|max:100',
			'password' => 'required|min:6',
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|unique:customers|email',
			'phone_number' => 'required|unique:customers|min:10'
		]);

		$result = array();
		$result["error"] = true;

		// validate fail, send error to application.
		if($validator->fails()) {

			$messages = $validator->messages();

			if($messages->has('username')) {
				$result['error_message'] = $messages->first('username');
				return Response::json($result);
			}

			if($messages->has('password')) {
				$result['error_message'] = $messages->first('password');
				return Response::json($result);
			}

			if($messages->has('firstname')) {
				$result['error_message'] = $messages->first('firstname');
				return Response::json($result);
			}

			if($messages->has('lastname')) {
				$result['error_message'] = $messages->first('lastname');
				return Response::json($result);
			}

			if($messages->has('email')) {
				$result['error_message'] = $messages->first('email');
				return Response::json($result);
			}

			if($messages->has('phone_number')) {
				$result['error_message'] = $messages->first('phone_number');
				return Response::json($result);
			}

		} else {

			// pass validate, create new customer.
			$customer = new Customer;
			$customer->unique_id = uniqid();
			$customer->username = $request->input('username');
			$customer->password = bcrypt($request->input('password'));
			$customer->firstname = $request->input('firstname');
			$customer->lastname = $request->input('lastname');
			$customer->email = $request->input('email');
			$customer->phone_number = $request->input('phone_number');
			$customer->save();

			// return result.
			$result["error"] = "false";
			$result["message"] = "Create new account success.";
			return Response::json($result);

		}

	}

}
