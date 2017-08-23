<?php namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Customer;
use App\Branch;
use App\Member;
use App\Shop;
use App\Http\Requests;
use App\Http\Requests\ShopInformationRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminShopController extends Controller {

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

		$shops = Shop::all();
		return view('admin.shops.index', compact('shops'));

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
			'username' => 'required|unique:shops|min:6|max:100',
			'password' => 'required|min:6',
			'email' => 'required|unique:shops|email|max:100',
			'owner' => 'required|max:100',
			'name' => 'required|unique:shops|max:100'
		]);

		if($validator->fails()) {
			return redirect('admin/shop')->withErrors($validator->errors());
		}

		Shop::create([
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
			'email' => $request->input('email'),
			'owner' => $request->input('owner'),
			'name' => $request->input('name'),
			'is_branch' => false
		]);

		return redirect('admin/shop')->with('flash_message', 'Create new shop complete.');

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

		$shop = Shop::find($id);
		if($shop->is_branch) {

			$branch = Branch::where('sub_id', '=', $id)->first();
			$main_id = $branch->main_id;
			$main_shop = Shop::find($main_id);
			$members = $main_shop->members()->where('is_member', '=', true)->get();
			$products = $main_shop->products;
			$rewards = $main_shop->rewards;

		} else {

			$members = $shop->members()->where('is_member', '=', true)->get();
			$products = $shop->products;
			$rewards = $shop->rewards;

		}

		if($shop->is_branch == true) {
			return view('admin.shops.show', compact('shop', 'members', 'products', 'rewards'));
		} else {
			$branches = $shop->branches;
			return view('admin.shops.show', compact('shop', 'members', 'products', 'rewards', 'branches'));
		}

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

		$shop = Shop::find($id);
		return view('admin.shops.edit', compact('shop'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ShopInformationRequest $request, $id)
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$input = $request->except('image');

		$shop = Shop::find($id);
		$shop->username = $input['username'];
		$shop->name = $input['name'];
		$shop->owner = $input['owner'];
		$shop->email = $input['email'];

		if($request->has('password')) {
			$shop->password = bcrypt($input['password']);
		}

		if($request->has('address')) {
			$shop->address = $input['address'];
		}

		if($request->has('detail')) {
			$shop->detail = $input['detail'];
		}

		if($request->has('discount')) {
			$shop->discount = $input['discount'];
		}

		if($request->has('start_point')) {
			$shop->start_point = $input['start_point'];
		}

		if($request->has('point_get')) {
			$shop->point_get = $input['point_get'];
		}

		if($request->has('point_condition')) {
			$shop->point_condition = $input['point_condition'];
		}

		$file = $request->file('image');

		if($file != NULL) {

			if(!is_null($shop->image)) {

				$old_file_name = $shop->image;
				$public_path = public_path('images/shops/');
				$file_path = $public_path.$old_file_name;
				unlink($file_path);

			}

			$path = 'images/shops';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$shop->id. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$shop->image = $filename;

		}

		if ($shop->save() == TRUE) {
			return redirect()->back()->with('flash_message', 'Edit shop complete.');
		}

		return redirect()->back()->with('error_message', 'Oops !! Some errors have occur. Please try again !!');

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

		$shop = Shop::find($id);

		if(!is_null($shop->image)) {
			$old_file_name = $shop->image;
			$public_path = public_path('images/shops/');
			$file_path = $public_path.$old_file_name;
			unlink($file_path);
		}

		$shop->delete();

		return 'success';

	}

	public function destroyLogo($id)
	{

		if(!Session::has('admin')) {
			return 'guest';
		}

		$shop = Shop::find($id);
		$file_name = $shop->image;

		$public_path = public_path('images/shops/');
		$file_path = $public_path.$file_name;
		unlink($file_path);

		$shop->image = null;
		$shop->save();

		return 'success';

	}

}
