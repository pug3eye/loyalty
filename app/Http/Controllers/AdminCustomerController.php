<?php namespace App\Http\Controllers;

use Session;
use App\Customer;
use App\Member;
use App\Shop;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCustomerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$customers = Customer::all();
		return view('admin.customers.index', compact('customers'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$validator = Validator::make($request->all(), [
			'username' => 'required|unique:customers|min:6|max:100',
			'password' => 'required|min:6',
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|unique:customers|email',
			'phone_number' => 'required|unique:customers|min:10'
		]);

		if($validator->fails()) {
			return redirect('admin/customer')->withErrors($validator->errors());
		}

		$customer = new Customer;
		$customer->unique_id = uniqid();
		$customer->username = $request->input('username');
		$customer->password = bcrypt($request->input('password'));
		$customer->firstname = $request->input('firstname');
		$customer->lastname = $request->input('lastname');
		$customer->email = $request->input('email');
		$customer->phone_number = $request->input('phone_number');
		$customer->save();

		return redirect('admin/customer')->with('flash_message', 'Create new customer complete.');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$customer = Customer::find($id);
		$members = $customer->members()->where('is_member', '=', true)->get();

		return view('admin.customers.show', compact('customer', 'members'));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$customer = Customer::find($id);
		return view('admin.customers.edit', compact('customer', 'password'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$validator = Validator::make($request->all(), [
			'username' => 'required|min:6|max:100',
			'password' => 'min:6',
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required|min:10',
			'unique_id' => 'required|max:13'
		]);

		if($validator->fails()) {
			return redirect('admin/customer')->withErrors($validator->errors());
		}

		$customer = Customer::find($id);
		$customer->username = $request->input('username');
		$customer->unique_id = $request->input('unique_id');
		$customer->username = $request->input('username');
		$customer->firstname = $request->input('firstname');
		$customer->lastname = $request->input('lastname');
		$customer->email = $request->input('email');
		$customer->phone_number = $request->input('phone_number');

		if($request->has('password')) {
			$customer->password = bcrypt($request->input('password'));
		}

		$customer->save();

		return redirect('admin/customer')->with('flash_message', 'Edit customer complete.');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		if(!Session::has('admin')) {
			return 'guest';
		}

		$customer = Customer::find($id);
		$customer->delete();

		return 'success';

	}

}
