<?php namespace App\Http\Controllers;

use App\Shop;
use App\Http\Requests;
use App\Http\Requests\SignupRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SignupController extends Controller {

	public function store(SignupRequest $request)
	{

		if ($request->input('password') != $request->input('password_confirmation')) {
			return redirect()->back()->with('flash_message', 'Password and Confirm Password are not match !!')->withInput($request->except('password'));
		}

		Shop::create([
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
			'email' => $request->input('email'),
			'owner' => $request->input('owner'),
			'name' => $request->input('name'),
			'is_branch' => false
		]);

		return redirect('login')->with('flash_message', 'Sign up success. You can login now');

	}

}
