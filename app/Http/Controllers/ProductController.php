<?php namespace App\Http\Controllers;

use Auth;
use App\Shop;
use App\Product;
use App\CheckBranch;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller {

	// Display a listing of the products.
	public function index()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// get product owned by auth user.
		$products = $user->products;

		return view('products.index', compact('products'));

	}

	// Show form for creating a new product.
	public function create()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		return view('products.add');

	}

	// Store newly created product in storage.
	public function store(ProductRequest $request)
	{
		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		// get auth user.
		$user = Auth::user();
		// get id of auth user.
		$user_id = $user['id'];

		// get input except image.
		$input = $request->except('image');

		// get image.
		$file = $request->file('image');

		// check product bardcode is unique for auth user or not.
		// null if not found.
		$checkProduct = $user->products->where('barcode', $input['code'])->first();
		if ( !is_null($checkProduct) ) {
			// not null value.
			return redirect()->back()->with('error_barcode', "Error")->withInput();
		}

		// create product object to store.
		$product = new Product;
		$product->shop_id = $user_id;
		$product->barcode = $input['code'];
		$product->name = $input['name'];
		$product->price = $input['price'];
		$product->point = $input['point'];
		$product->detail = $input['detail'];

		// check have promotion or not.
		if( $input['has_promotion'] == 1) {

			// have protmoion.

			$product->has_promotion = true;

			if($request->has('promotion_price')) {
				$product->promotion_price = $input['promotion_price'];
			}

			if($request->has('promotion_point')) {
				$product->promotion_point = $input['promotion_point'];
			}

			$product->promotion_start = $input['start_date'];
			$product->promotion_end = $input['end_date'];

			// uncomment if use timestamp data type.
			// get date and store at midnight of input date.
			// $dateInput = $input['date'];
			// $dt = Carbon::createFromformat('Y-m-d', $dateInput);
			// $dpe = $dt->endOfDay();
			// $product->double_point_expired = $dpe;

		}

		// check input have image or not.
		if( $file != NULL ) {

			// have image. set new name for image.
			// move image to prefer directory and store image name in database.
			$path = 'images/products';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$user_id. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$product->image = $filename;

		}

		// store date success.
		if ( $product->save() == TRUE ) {
			// move back to add product page with some feedback.
			return redirect('product/add')->with('flash_message', "Add product ".$input['name']." success.");
		}

		// some error occurs.
		return redirect('product/add')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	// Display the specified product.
	public function show($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		// $user = Auth::user();

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// check id request is owned by auth user or not.
		// if found return product to user.
		// if not found redirect back.
		$product = $user->products->find($id);
		if ( is_null($product) ) {
			// auth user is not owner of this product id
			return redirect()->back();
		}

		return view('products.show', compact('product'));

	}

	// Show the form for editing the specified product.
	public function edit($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		$user = Auth::user();
		// get specified product.
		$product = $user->products->find($id);

		if ( is_null($product) ) {
			return redirect()->back();
		}

		return view('products.edit', compact('product'));

	}

	// Update the specified product in storage.
	public function update(EditProductRequest $request, $id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		$user = Auth::user();
		// get input except image.
		$input = $request->except('image');
		// get image.
		$file = $request->file('image');
		// get specified product.
		$product = $user->products->find($id);

		if ( is_null($product) ) {
			return redirect()->back();
		}

		// Update data.
		$product->name = $input['name'];
		$product->price = $input['price'];
		$product->point = $input['point'];
		$product->detail = $input['detail'];

		// check have promotion or not.
		if( $input['has_promotion'] == 1) {

			// have promotion.

			$product->has_promotion = true;

			if($request->has('promotion_price')) {
				$product->promotion_price = $input['promotion_price'];
			}

			if($request->has('promotion_point')) {
				$product->promotion_point = $input['promotion_point'];
			}

			$product->promotion_start = $input['start_date'];
			$product->promotion_end = $input['end_date'];

		} else {

			$product->has_promotion = false;
			$product->promotion_price = null;
			$product->promotion_point = null;
			$product->promotion_start = null;
			$product->promotion_end = null;

		}

		// check input have image or not.
		if ( $file != NULL ) {

			// have input image.

			// check product already have image or not.
			if ( !is_null($product->image) ) {

				// delete old image.
				$old_file_name = $product->image;
				$public_path = public_path('images/products/');
				$file_path = $public_path.$old_file_name;
				unlink($file_path);

			}

			// then move new image to prefer directory and store image name in database.
			$path = 'images/products';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$user['id']. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$product->image = $filename;

		}

		// store date success.
		if ( $product->save() == TRUE ) {
			// move back to index product page with some feedback.
			return redirect('product')->with('flash_message', "Edit success");
		}

		// some error occurs.
		return redirect('product')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	// Remove the specified product from storage.
	public function destroy($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		// get auth user.
		$user = Auth::user();

		// check id request is owned by auth user or not.
		// if found return product to user.
		// if not found redirect back.
		$product = $user->products->find($id);
		if ( is_null($product) ) {
			// auth user is not owner of this product id
			return 'error';
		}

		// get image name.
		$file_name = $product->image;

		// delete product.
		// if success then check about image of product.
		if ($product->delete()) {
			// check image is null or not.
			// not null mean have image.
			if ( !is_null($file_name) ) {
				// have image then delete it.
				$public_path = public_path('images/products/');
				$file_path = $public_path.$file_name;
				unlink($file_path);
			}
		}

		return 'success';

	}

	// Remove only image of specified product.
	public function destroyImage($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		// get auth user.
		$user = Auth::user();

		// check id request is owned by auth user or not.
		// if found return product to user.
		// if not found redirect back.
		$product = $user->products->find($id);
		if ( is_null($product) ) {
			// auth user is not owner of this product id
			return 'error';
		}

		// get image name.
		$file_name = $product->image;

		// check image is null or not.
		// not null mean have image.
		if ( !is_null($file_name) ) {

			// have image then delete it.
			$public_path = public_path('images/products/');
			$file_path = $public_path.$file_name;
			unlink($file_path);

			// set null to product image.
			$product->image = NULL;
			$product->save();
		}

		return 'success';

	}

}
