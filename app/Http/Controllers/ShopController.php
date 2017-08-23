<?php namespace App\Http\Controllers;

use Auth;
use App\Shop;
use App\Branch;
use App\CheckBranch;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ShopInformationRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ShopController extends Controller {

	// show edit shop info form.
	public function edit()
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		$user = Auth::user();

		if ( CheckBranch::isBranch() ) {
			return view('shops.branch_edit', compact('user'));
		}

		return view('shops.edit', compact('user'));

	}

	public function update(ShopInformationRequest $request)
	{

		if(Auth::guest()) {
			return redirect('login');
		}

		$input = $request->except('image');

		if ( CheckBranch::isBranch() ) {

			$user = Auth::user();

			if($request->has('address')) {
				$user->address = $input['address'];
			}

			$user->save();
			return redirect('edit')->with('flash_message', "edit success");

		}

		// get auth user, and all input.
		$user = Auth::user();

		$file = $request->file('image');

		if($request->has('address')) {
			$user->address = $input['address'];
		}

		if($request->has('detail')) {
			$user->detail = $input['detail'];
		}

		if($request->has('discount')) {
			$user->discount = $input['discount'];
		}

		if($request->has('start_point')) {
			$user->start_point = $input['start_point'];
		}

		if($request->has('point_get')) {
			$user->point_get = $input['point_get'];
		}

		if($request->has('point_condition')) {
			$user->point_condition = $input['point_condition'];
		}

		// check input has image or not.
		if($file != NULL) {

			// input has image.

			// check user already has logo or not.
			if(!is_null($user->image)) {

				// has logo, delete old logo file.
				$old_file_name = $user->image;
				$public_path = public_path('images/shops/');
				$file_path = $public_path.$old_file_name;
				unlink($file_path);

			}

			$path = 'images/shops';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$user['id']. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$user->image = $filename;

		}

		// update data.
		if ( $user->save() == TRUE ) {
			// move back to index page with some feedback.
			$this->updateBranches();
			return redirect('edit')->with('flash_message', "edit success");
		}

		// some error occurs.
		return redirect('edit')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	public function destroyLogo()
	{

		if(Auth::guest()) {
			return 'guest';
		}

		// get auth user.
		$user = Auth::user();

		// get image name.
		$file_name = $user->image;

		// delete image.
		$public_path = public_path('images/shops/');
		$file_path = $public_path.$file_name;
		unlink($file_path);

		// set to default value and update.
		$user->image = null;
		$user->save();

		$this->deleteBranchLogo();

		return 'success';

	}

	// update data of all branches.
	private function updateBranches()
	{

		$user = Auth::user();
		$branches = Branch::where('main_id', '=', $user->id)->get();

		foreach ($branches as $branch)
		{

			$shop = Shop::find($branch->sub_id);
			$shop->detail = $user->detail;
			$shop->discount = $user->discount;
			$shop->start_point = $user->start_point;
			$shop->point_get = $user->point_get;
			$shop->point_condition = $user->point_condition;

			$path = 'images/shops/';
			$file = $path.$user->image;
			$newFileName = 'branch-'.$shop->id.'-'.$user->image;
			$newFile = $path.$newFileName;

			if (copy($file, $newFile)) {
				$shop->image = $newFileName;
			}

			$shop->save();

		}

	}

	private function deleteBranchLogo()
	{

		$user = Auth::user();
		$branches = Branch::where('main_id', '=', $user->id)->get();

		foreach ($branches as $branch)
		{

			$shop = Shop::find($branch->sub_id);
			$file_name = $shop->image;

			// delete image.
			$public_path = public_path('images/shops/');
			$file_path = $public_path.$file_name;
			unlink($file_path);

			// set to default value and update.
			$shop->image = null;
			$shop->save();

		}

	}

}
