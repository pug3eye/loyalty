<?php namespace App\Http\Controllers;

use Auth;
use Session;
use App\Customer;
use App\Shop;
use App\Product;
use App\Reward;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller {

	public function index()
	{

		if(!Session::has('admin')) {
			return redirect('admin/login');
		}

		$count = array();
		$count['customers'] = Customer::all()->count();
		$count['shops'] = Shop::all()->count();
		$count['products'] = Product::all()->count();
		$count['rewards'] = Reward::all()->count();

		return view('admin.dashboard.index', compact('count'));

	}

}
