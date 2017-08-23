<?php namespace App\Http\Controllers;

use Hash;
use Session;
use App\Admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminLoginController extends Controller {

	public function showLogin()
	{

		if(Session::has('admin')) {
			return redirect('admin/dashboard');
		}

		return view('admin.login');

	}

	public function login(Request $request)
	{

		if(Session::has('admin')) {
			return redirect('admin/dashboard');
		}

		$username = $request->input('username');
		$password = $request->input('password');

		$admin = Admin::where('username', '=', $username)->first();

		if(is_null($admin)) {
			return redirect()->back()->with('error_message', 'Username or Password is wrong !!')->withInput($request->except('password'));
		}

		if(Hash::check($password, $admin->password)) {
			Session::put('admin', 'admin');
			return redirect('admin/dashboard');
		} else {
			return redirect()->back()->with('error_message', 'Username or Password is wrong !!')->withInput($request->except('password'));
		}

	}

	public function logout()
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		} else {
			Session::flush();
			return redirect('admin/login');
		}

	}

}
