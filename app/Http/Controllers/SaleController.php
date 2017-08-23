<?php namespace App\Http\Controllers;

use DB;
use Auth;
use Response;
use Session;
use App\Shop;
use App\Product;
use App\PointHistory;
use App\Customer;
use App\Member;
use App\SaleProduct;
use App\CheckBranch;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SaleController extends Controller {

	// Display a form for pos service.
	public function index()
	{

		// check auth.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		$saleProductsArray = Session::get('sales', array());
		$member_id = Session::get('member', null);
		$summary = $this->calculate();

		if(is_null($member_id)) {
			return view('sales.index', compact('saleProductsArray', 'summary'));
		} else {
			$member = Member::find($member_id);
			$detail = $member->customer()->first();
			return view('sales.index', compact('saleProductsArray', 'member', 'detail', 'summary'));
		}

	}

	// Autocomplete search product form.
	public function getProductsList(Request $request)
	{

		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// create variable results for return
		$results = array();

		// get input value
		$value = $request->input('term');
		// query products for Autocomplete
		$queries = Product::whereRaw('shop_id = '.$user['id'].' AND (barcode like \''.$value.'%\' OR name like \''.$value.'%\')')->get();

		foreach ($queries as $product)
		{
			    $results[] = [ 'id' => $product->id, 'value' => $product->barcode.' '.$product->name ];
		}

		return Response::json($results);

	}

	// Autocomplete search members form.
	public function getMembersList(Request $request)
	{

		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// create variable results for return
		$results = array();

		// get input value
		$value = $request->input('term');

		// query members for Autocomplete
		$queries = DB::table('members')
								->join('customers', 'members.customer_id', '=', 'customers.id')
								->select('members.id', 'members.point', 'customers.firstname', 'customers.lastname')
								->whereRaw('members.shop_id = '.$user->id.' AND members.is_member = true AND (customers.firstname like \''.$value.'%\' OR customers.lastname like \''.$value.'%\')')
								->get();

		foreach ($queries as $member)
		{
					$results[] = [ 'id' => $member->id, 'value' => $member->firstname.' '.$member->lastname, 'point' => $member->point ];
		}

		return Response::json($results);

	}

	public function storeBuyMember($id)
	{

		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get detail about member and store in session.
		$member = Member::find($id);
		$detail = $member->customer()->first();
		Session::put('member', $member->id);

		// create result to send back.
		$summary = $this->calculate();
		$result = array();
		$result['id'] = $member->id;
		$result['name'] = $detail->firstname.' '.$detail->lastname;
		$result['point'] = $member->point;
		$result['total'] = $summary['total'];
		$result['get_point'] = $summary['get_point'];

		return Response::json($result);

	}

	public function clearBuyMember()
	{
		if ( Auth::guest() ) {
			return redirect('login');
		}
		Session::forget('member');

		$summary = $this->calculate();
		$result = array();
		$result['total'] = $summary['total'];
		$result['get_point'] = $summary['get_point'];

		return Response::json($result);

	}

	// store sale product click by autocomplete.
	// quantity is 1 if product is first time select, +1 is already have.
	public function storeSaleProduct($id) {

		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get data about product.
		// $user = Auth::user();

		// get auth user.
		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$product = $user->products->find($id);
		$hasPromotion = $product->has_promotion;
		$isPromotion = false;

		// check if product has promotion or not.
		if ($hasPromotion) {

			// has promotion.
			// get date now, start promotion and end promotion date.
			// compare date, if today is between start promotion and end promotion. then it's promotion time.
			// isPromotion is true if in promotion time.
			$today = Carbon::now()->hour(0)->minute(0)->second(0);
			$promotion_start = Carbon::createFromFormat('Y-m-d', $product->promotion_start)->hour(0)->minute(0)->second(0);
			$promotion_end = Carbon::createFromFormat('Y-m-d', $product->promotion_end)->hour(0)->minute(0)->second(0);
			$isPromotion = $today->between($promotion_start, $promotion_end);

		}

		// retrive data in session about sale products.
		// if not have, create array for store sale products.
		$saleProductsArray = Session::get('sales', array());

		// check this product is already has in session or not.
		$isHas = array_key_exists(strval($product->barcode), $saleProductsArray);

		$saleProduct = new saleProduct();
		$saleProduct->setProductId($product->id);
		$saleProduct->setProductBarcode($product->barcode);
		$saleProduct->setName($product->name);

		if ($isHas) {
			// already has, update quantity of product
			$oldSaleProduct = $saleProductsArray[strval($product->barcode)];
			$oldQuantity = $oldSaleProduct->getQuantity();
			$saleProduct->setQuantity($oldQuantity+1);
		} else {
			// not has, set quantity to 1
			$saleProduct->setQuantity(1);
		}

		// set price and point.
		if ($isPromotion) {

			// price
			if (is_null($product->promotion_price)) {
				// no promotion_price.
				$saleProduct->setPrice($product->price);
			} else {
				$saleProduct->setPrice($product->promotion_price);
				$saleProduct->setHasPromotionPrice(true);
			}
			// point
			if (is_null($product->promotion_point)) {
				// no promotion_point.
				$saleProduct->setPoint($product->point);
			} else {
				$saleProduct->setPoint($product->promotion_point);
				$saleProduct->setHasPromotionPoint(true);
			}

		} else {
			$saleProduct->setPrice($product->price);
			$saleProduct->setPoint($product->point);
			$saleProduct->setHasPromotionPrice(false);
			$saleProduct->setHasPromotionPoint(false);

		}

		$saleProductsArray[strval($saleProduct->getProductBarcode())] = $saleProduct;

		Session::put('sales', $saleProductsArray);

		$summary = $this->calculate();

		$result = array();
		$result['id'] = $saleProduct->getProductId();
		$result['barcode'] = $saleProduct->getProductBarcode();
		$result['name'] = $product->name;
		$result['price'] = $saleProduct->getPrice();
		$result['point'] = $saleProduct->getPoint();
		$result['is_has'] = $isHas;
		$result['has_promotion_price'] = $saleProduct->getHasPromotionPrice();
		$result['has_promotion_point'] = $saleProduct->getHasPromotionPoint();
		$result['total'] = $summary['total'];
		$result['get_point'] = $summary['get_point'];

		return Response::json($result);

	}

	// updated Quantity of sale product by keypress function.
	public function updateSaleProduct(Request $request, $barcode) {

		$input = $request->all();
		$quantity = $input['quantity'];

		if ( Auth::guest() ) {
			return redirect('login');
		}

		$saleProduct = new saleProduct();

		if (Session::has('sales')) {
			$saleProductsArray = Session::get('sales');
			$isHas = array_key_exists(strval($barcode), $saleProductsArray);
			if ($isHas) {
				// update data.
				$oldSaleProduct = $saleProductsArray[strval($barcode)];
				$saleProduct->setProductId($oldSaleProduct->getProductId());
				$saleProduct->setProductBarcode($barcode);
				$saleProduct->setName($oldSaleProduct->getName());
				$saleProduct->setQuantity($quantity);
				$saleProduct->setPrice($oldSaleProduct->getPrice());
				$saleProduct->setPoint($oldSaleProduct->getPoint());
				$saleProduct->setHasPromotionPrice($oldSaleProduct->getHasPromotionPrice());
				$saleProduct->setHasPromotionPoint($oldSaleProduct->getHasPromotionPoint());
				$saleProductsArray[strval($barcode)] = $saleProduct;
				Session::put('sales', $saleProductsArray);

				// create result to send back.
				// total price and total point, and calculate all price and point too.
				$result = array();
				$summary = $this->calculate();
				$result['total_price'] = $saleProduct->getQuantity()*$saleProduct->getPrice();
				$result['total_point'] = $saleProduct->getQuantity()*$saleProduct->getPoint();
				$result['total'] = $summary['total'];
				$result['get_point'] = $summary['get_point'];

				return Response::json($result);

			}
		}

		return 'fail';

	}

	// delete specified product in session.
	public function deleteSaleProduct($barcode) {

		if ( Auth::guest() ) {
			return redirect('login');
		}

		if (Session::has('sales')) {
			$saleProductsArray = Session::get('sales');
			$isHas = array_key_exists(strval($barcode), $saleProductsArray);
			if ($isHas) {
				unset($saleProductsArray[$barcode]);
				Session::put('sales', $saleProductsArray);

				$result = array();
				$summary = $this->calculate();
				$result['total'] = $summary['total'];
				$result['get_point'] = $summary['get_point'];

				return Response::json($result);
			}
		}

		return 'fail';

	}

	public function calculate()
	{

		$saleProductsArray = Session::get('sales', array());
		$member_id = Session::get('member', null);
		$result = array();
		$total = 0;
		$get_point = 0;

		if(sizeof($saleProductsArray) == 0) {
			$result['total'] = 0;
			$result['get_point'] = 0;
			return $result;
		}

		foreach ($saleProductsArray as $saleProduct) {
			$total += $saleProduct->getPrice()*$saleProduct->getQuantity();
			$get_point += $saleProduct->getPoint()*$saleProduct->getQuantity();
		}

		$user = Auth::user();
		// if ( CheckBranch::isBranch() ) {
		// 	$main_id = CheckBranch::mainShopId();
		// 	$user = Shop::find($main_id);
		// } else {
		// 	$user = Auth::user();
		// }

		if(!is_null($member_id)) {
			$total = $total - ($total*($user->discount/100));
		}

		if(!is_null($user->point_condition) && !is_null($user->point_get) && ($user->point_condition != 0)) {
			$bonus_point = (int) ($total/$user->point_condition)*$user->point_get;
			$get_point = $get_point + $bonus_point;
		}

		$result['total'] = number_format((float)$total, 2, '.', '');
		$result['get_point'] = $get_point;

		return $result;

	}

	public function completeSale(Request $request)
	{

		$member_id = Session::get('member', null);

		$input = $request->all();
		$cash = number_format((float)$input['cash'], 2, '.', '');
		$summary = $this->calculate();

		if($cash < $summary['total']) {
			return 'error';
		}

		Session::forget('member');
		Session::forget('sales');

		if(is_null($member_id)) {
			return view('sales.summary', compact('cash', 'summary'));
		} else {

			// get member detail and update point.
			$member = Member::find($member_id);
			$detail = $member->customer()->first();
			$oldPoint = $member->point;
			$newPoint = $oldPoint + $summary['get_point'];
			$member->point = $newPoint;
			$member->save();

			$pointHistory = new PointHistory;
			$pointHistory->member_id = $member_id;
			$pointHistory->point = $summary['get_point'];
			$pointHistory->is_add = true;
			$pointHistory->detail = 'buy products and get points';
			$pointHistory->created_at = Carbon::now();
			$pointHistory->save();

			return view('sales.summary', compact('cash', 'summary', 'member', 'detail'));

		}

	}

	public function allProducts()
	{

		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$products = $user->products;

		return view('sales.products', compact('products'));

	}

	public function selectFromAllProducts($id)
	{

		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$product = $user->products->find($id);
		$hasPromotion = $product->has_promotion;
		$isPromotion = false;

		// check if product has promotion or not.
		if ($hasPromotion) {

			// has promotion.
			// get date now, start promotion and end promotion date.
			// compare date, if today is between start promotion and end promotion. then it's promotion time.
			// isPromotion is true if in promotion time.
			$today = Carbon::now()->hour(0)->minute(0)->second(0);
			$promotion_start = Carbon::createFromFormat('Y-m-d', $product->promotion_start)->hour(0)->minute(0)->second(0);
			$promotion_end = Carbon::createFromFormat('Y-m-d', $product->promotion_end)->hour(0)->minute(0)->second(0);
			$isPromotion = $today->between($promotion_start, $promotion_end);

		}

		// retrive data in session about sale products.
		// if not have, create array for store sale products.
		$saleProductsArray = Session::get('sales', array());

		// check this product is already has in session or not.
		$isHas = array_key_exists(strval($product->barcode), $saleProductsArray);

		$saleProduct = new saleProduct();
		$saleProduct->setProductId($product->id);
		$saleProduct->setProductBarcode($product->barcode);
		$saleProduct->setName($product->name);

		if ($isHas) {
			// already has, update quantity of product
			$oldSaleProduct = $saleProductsArray[strval($product->barcode)];
			$oldQuantity = $oldSaleProduct->getQuantity();
			$saleProduct->setQuantity($oldQuantity+1);
		} else {
			// not has, set quantity to 1
			$saleProduct->setQuantity(1);
		}

		// set price and point.
		if ($isPromotion) {

			// price
			if (is_null($product->promotion_price)) {
				// no promotion_price.
				$saleProduct->setPrice($product->price);
			} else {
				$saleProduct->setPrice($product->promotion_price);
				$saleProduct->setHasPromotionPrice(true);
			}
			// point
			if (is_null($product->promotion_point)) {
				// no promotion_point.
				$saleProduct->setPoint($product->point);
			} else {
				$saleProduct->setPoint($product->promotion_point);
				$saleProduct->setHasPromotionPoint(true);
			}

		} else {
			$saleProduct->setPrice($product->price);
			$saleProduct->setPoint($product->point);
			$saleProduct->setHasPromotionPrice(false);
			$saleProduct->setHasPromotionPoint(false);

		}

		$saleProductsArray[strval($saleProduct->getProductBarcode())] = $saleProduct;

		Session::put('sales', $saleProductsArray);

		return redirect('sale');

	}

	public function clearSale() {
		Session::forget('member');
		Session::forget('sales');
		return 'success';
	}

}
