<?php namespace App\Http\Controllers;

use Session;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminProductController extends Controller {

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

		$products = Product::all();
		return view('admin.products.index', compact('products'));

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
			return 'guest';
		}

		$product = Product::find($id);
		return view('products.show', compact('product'));

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

		$product = Product::find($id);
		$file_name = $product->image;

		if ($product->delete()) {
			if ( !is_null($file_name) ) {
				$public_path = public_path('images/products/');
				$file_path = $public_path.$file_name;
				unlink($file_path);
			}
		}

		return 'success';

	}

}
