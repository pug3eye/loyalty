<?php namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Shop;
use App\Branch;
use App\CheckBranch;
use App\Http\Requests;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\ShopInformationRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BranchController extends Controller {

	public function index()
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		$user = Auth::user();
		$branches = $user->branches;

		return view('branches.index', compact('branches'));

	}

	// Show form for creating a new branch.
	public function create()
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		return view('branches.add');

	}

	public function store(CreateBranchRequest $request)
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		// check password and confirm password are match.
		if ($request->input('password') != $request->input('password_confirmation')) {
			return redirect()->back()->with('error_message', 'Password and Confirm Password are not match !!')->withInput($request->except('password'));
		}

		// get auth user and input.
		$user = Auth::user();
		$input = $request->all();

		// create new shop as branch.
		$shop = new Shop;
		$shop->username = $input['username'];
		$shop->password = bcrypt($input['password']);
		$shop->is_branch = true;
		$shop->email = $input['email'];
		$shop->name = $user->name.' ('. $input['name']. ')';
		$shop->owner = $user->owner;
		$shop->address = $input['address'];
		$shop->detail = $user->detail;
		$shop->discount = $user->discount;
		$shop->start_point = $user->start_point;
		$shop->point_get = $user->point_get;
		$shop->point_condition = $user->point_condition;

		$shop->save();

		// check user already has logo or not.
		if(!is_null($user->image)) {

			// has logo
			$path = 'images/shops/';
			$file = $path.$user->image;
			$newFileName = 'branch-'.$shop->id.'-'.$user->image;
			$newFile = $path.$newFileName;

			if (copy($file, $newFile)) {
				$shop->image = $newFileName;
			}

		}

		$shop->save();

		// create branch relation.
		$branch = new Branch;
		$branch->main_id = $user->id;
		$branch->sub_id = $shop->id;
		$branch->name = $input['name'];
		$branch->save();

		return redirect('branch/add')->with('flash_message', "Success");

	}

	public function show($id)
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		$user = Auth::user();
		$branch = $user->branches->find($id);
		$shop = Shop::find($branch->sub_id);

		return view('branches.show', compact('shop'));

	}

	public function edit($id)
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		// get auth user.
		$user = Auth::user();
		// get specified product.
		$branch = $user->branches->find($id);

		if ( is_null($branch) ) {
			return redirect()->back();
		}

		return view('branches.edit', compact('branch'));

	}

	public function update(ShopInformationRequest $request, $id)
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		$user = Auth::user();

		$input = $request->except('image');
		$file = $request->file('image');
		$branch = Branch::find($id);
		$shop = Shop::find($branch->sub_id);

		$shop->name = $user->name.' ('. $input['name']. ')';

		$branch->name = $input['name'];
		$branch->save();

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

		// check input has image or not.
		if($file != NULL) {

			// input has image.

			// check user already has logo or not.
			if(!is_null($shop->image)) {

				// has logo, delete old logo file.
				$old_file_name = $shop->image;
				$public_path = public_path('images/shops/');
				$file_path = $public_path.$old_file_name;
				unlink($file_path);

			}

			$path = 'images/shops';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$shop['id']. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$shop->image = $filename;

		}

		// update data.
		if ( $shop->save() == TRUE ) {
			// move back to index page with some feedback.
			return redirect('branch')->with('flash_message', "edit success");
		}

		// some error occurs.
		return redirect('branch')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	public function destroy($id)
	{

		if (Auth::guest()) {
			return 'guest';
		}

		if (CheckBranch::isBranch()) {
			return 'error';
		}

		$user = Auth::user();

		$branch = $user->branches->find($id);

		if (is_null($branch))  {
			return 'error';
		}

		$shop = Shop::find($branch->sub_id);

		// get image name.
		$file_name = $shop->image;

		if ($shop->delete()) {
			// check image is null or not.
			// not null mean have image.
			if ( !is_null($file_name) ) {
				// have image then delete it.
				$public_path = public_path('images/shops/');
				$file_path = $public_path.$file_name;
				unlink($file_path);
			}
		}

	}

	public function destroyImage($id)
	{

		if(Auth::guest()) {
			return 'guest';
		}

		if (CheckBranch::isBranch()) {
			return redirect()->back();
		}

		$branch = Branch::find($id);
		$shop = Shop::find($branch->sub_id);

		// get image name.
		$file_name = $shop->image;

		// delete image.
		$public_path = public_path('images/shops/');
		$file_path = $public_path.$file_name;
		unlink($file_path);

		// set to default value and update.
		$shop->image = null;
		$shop->save();

	}

	public function test()
	{
		// return CheckBranch::isBranch();
		// return CheckBranch::mainShopId();
		$user = Auth::user();
		$path = 'images/shops/';
		$file = $path.$user->image;
		$newFile = $path.'-'.$user->id.'-'.$user->image;

		if (!copy($file, $newFile)) {
			return 'fail';
		}

		return 'ok';

	}

}
