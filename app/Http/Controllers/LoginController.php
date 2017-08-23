<?php namespace App\Http\Controllers;

use Auth;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;

class LoginController extends Controller {

	// login
	public function login(LoginRequest $request)
	{
		if (Auth::attempt($request->only(['username', 'password']), $request->has('remember'))) {
			return redirect('sale');
		} else {
			return redirect()->back()->with('error_message', 'Username or Password is wrong !!')->withInput($request->except('password'));
		}
	}

	//  logout
	public function logout()
	{
		if (Auth::guest()) {
			return redirect('login');
		} else {
			Session::flush();
			return redirect('login');
		}
	}

}
