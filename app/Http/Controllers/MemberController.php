<?php namespace App\Http\Controllers;

use Auth;
use DB;
use Response;
use App\Shop;
use App\Customer;
use App\Member;
use App\Reward;
use App\RedeemReward;
use App\CheckBranch;
use App\Generate;
use App\PointHistory;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller {

	// Web application function.

	public function index()
	{

		//  check is auth or not.
		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$members = $user->members()->where('is_member', '=', true)->get();

		// return $members;
		return view('members.index', compact('members'));

	}

	// Show all register member requests.
	public function request()
	{

		//  check is auth or not.
		if(Auth::guest()) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$members = $user->members()->where('is_member', '=', false)->get();

		// return $members;
		return view('members.request', compact('members'));
	}

	// Accept new member.
	public function accept($id)
	{

		//  check is auth or not.
		if(Auth::guest()) {
			return 'guest';
		}

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$member = $user->members()->find($id);

		if($member->is_member) {
			// already member.
			return 'fail';
		}

		$member->is_member = true;

		// check is shop define a start_point.
		if(!is_null($user->start_point) && ($user->start_point != 0)) {

			// define start point.
			$member->point = $user->start_point;

			$pointHistory = new PointHistory;
			$pointHistory->member_id = $member->id;
			$pointHistory->point = $user->start_point;
			$pointHistory->is_add = true;
			$pointHistory->detail = 'Start points for new member';
			$pointHistory->created_at = Carbon::now();
			$pointHistory->save();

		}

		$member->save();

		return 'success';

	}

	// Delete member request.
	public function delete($id)
	{

		// check is auth or not.
		if(Auth::guest()) {
			return 'guest';
		}

		// find member.
		$user = Auth::user();
		$member = $user->members()->find($id);

		if($member->is_member) {
			// already member.
			return 'fail';
		}

		$member->delete();

		return 'success';

	}

	// show point history and redeem reward of member.
	public function show($id)
	{

		//  check is auth or not.
		if(Auth::guest()) {
			return redirect('login');
		}

		// find member and get detail.
		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$member = $user->members()->find($id);
		$redeems = $member->redeemHistories()->get();
		$pointHistories = DB::table('point_histories')
									->select('*')
									->where('member_id', '=', $member->id)
									->orderBy('id', 'desc')
									->get();

		return view('members.show', compact('member', 'redeems', 'pointHistories'));

	}

	public function destroy($id)
	{

		//  check is auth or not.
		if(Auth::guest()) {
			return 'guest';
		}

		// find member.
		$user = Auth::user();
		$member = $user->members()->find($id);
		$member->delete();

		return 'success';

	}

	// End web application function.






	// Android application function.

	// send request to register member.
	public function register(Request $request)
	{

		$result = array();
		$result["error"] = true;
		$result["is_member"] = true;

		$validator = Validator::make($request->all(), [
			'unique_id' => 'required',
			'shop_id' => 'required'
		]);

		if($validator->fails()) {
			$result["error_message"] = 'required parameters is missing';
			return Response::json($result);
		}

		$result["error"] = false;

		// find customer and shop, then check customer is already register or not.
		$customer = Customer::where('unique_id', '=', $request->input('unique_id'))->first();
		$shop = Shop::find($request->input('shop_id'));
		$member = Member::where('customer_id', '=', $customer->id)->where('shop_id', '=', $shop->id)->first();

		if ( is_null($member) ) {
			// customer are not register yet, then let register.

			$result["is_member"] = false;
			$result["message"] = 'Please wait for accept by shop';

			$member = new Member;
			$member->customer_id = $customer->id;
			$member->shop_id = $shop->id;
			$member->point = 0;
			$member->is_member = false;
			$member->save();

			return Response::json($result);

		}

		$result["message"] = 'Please wait for accept by shop';

		return Response::json($result);

	}

	// redeem reward by member.
	public function redeemReward(Request $request)
	{

		$result = array();
		$result["error"] = true;

		$validator = Validator::make($request->all(), [
			'unique_id' => 'required',
			'reward_id' => 'required'
		]);

		if($validator->fails()) {
			$result["message"] = "Parameters is missing.";
			return Response::json($result);
		}

		$customer = Customer::where('unique_id', '=', $request->input('unique_id'))->first();
		$reward = Reward::find($request->input('reward_id'));

		if(is_null($customer) || is_null($reward)) {
			$result["message"] = 'customer or reward not found.';
			return Response::json($result);
		}

		$member = Member::where('customer_id', '=', $customer->id)->where('shop_id', '=', $reward->shop_id)->first();

		// return Response::json($member);

		if(is_null($member)) {
			$result["message"] = 'Member not found.';
			return Response::json($result);
		}

		$result["error"] = false;
		$result["can_redeem"] = false;

		if($member->point >= $reward->point_use) {

			// can redeem.
			$result["can_redeem"] = true;

			// update point of member and save.
			// $newPoint = $member->point - $reward->point_use;
			// $member->point = $newPoint;
			// $member->save();

			// create point history of member.
			// $pointHistory = new PointHistory;
			// $pointHistory->member_id = $member->id;
			// $pointHistory->point = $reward->point_use;
			// $pointHistory->is_add = false;
			// $pointHistory->detail = 'redeem reward "'.$reward->name.'"';
			// $pointHistory->created_at = Carbon::now();
			// $pointHistory->save();

			// create redeem reward transaction.
      $find = true;
      while($find) {
        $code = Generate::generateCode();
        $redeem = RedeemReward::where('code', '=', $code)->first();
        if( is_null($redeem) ) {
          $find = false;
        }
      }

			$redeem_transaction = new RedeemReward;
			$redeem_transaction->member_id = $member->id;
			$redeem_transaction->reward_id = $reward->id;
			$redeem_transaction->code = $code;
			$redeem_transaction->used = false;
			$redeem_transaction->created_at = Carbon::now();
			$redeem_transaction->save();

			$result["message"] = $code;
			return Response::json($result);

		}

		$result["message"] = 'Your points is not enough';
		return Response::json($result);

	}

	// show point histories of member.
	public function pointHistories(Request $request, $id)
	{

		$result = array();
		$result["error"] = true;

		$validator = Validator::make($request->all(), [
			'unique_id' => 'required',
		]);

		if($validator->fails()) {
			$result["message"] = "Parameters is missing.";
			return Response::json($result);
		}

		$customer = Customer::where('unique_id', '=', $request->input('unique_id'))->first();

		if(is_null($customer)) {
			$result["message"] = 'Customer not found.';
			return Response::json($result);
		}

		$member = $customer->members()->where('shop_id', '=', $id)->first();

		if(is_null($member)) {
			$result["message"] = 'Member not found.';
			return Response::json($result);
		}

		$histories = DB::table('point_histories')
									->select('*')
									->where('member_id', '=', $member->id)
									->orderBy('created_at', 'desc')
									->get();

		$result["error"] = false;
		$result["histories"] = $histories;

		return Response::json($result);

	}

	// show shop detail.
	public function showShopDetail($id)
	{

		$shop = DB::table('shops')
							->select('id', 'name', 'owner', 'email', 'image', 'address', 'detail', 'discount', 'start_point')
							->where('id', '=', $id)
							->first();

		return Response::json($shop);

	}

	// send id, name and image of shop that customer is member to android application.
	public function showMembers(Request $request)
	{

		$result = array();
		$result["error"] = true;

		$validator = Validator::make($request->all(), [
			'unique_id' => 'required',
		]);

		if($validator->fails()) {
			$result["message"] = "Parameters is missing.";
			return Response::json($result);
		}

		$unique_id = $request->input('unique_id');

		$customer = Customer::where('unique_id', '=', $unique_id)->first();

		if (is_null($customer)) {
			$result["message"] = 'Customer not found.';
			return Response::json($result);
		}

		$result["error"] = false;
		$result["has_member"] = true;

		$members = DB::table('shops')
								->join('members', 'shops.id', '=', 'members.shop_id')
								->select('shops.id', 'shops.name', 'shops.image')
								->where('members.customer_id', '=', $customer->id)
								->where('members.is_member', '=', true)
								->orderBy('shops.name', 'asc')
								->get();

		if(sizeof($members) == 0) {
			$result["has_member"] = false;
			$result["message"] = 'Not member of any shops.';
			return Response::json($result);
		}

		$result["members"] = $members;

		return Response::json($result);

	}

	public function showRewardsAndMemberPoint(Request $request, $id)
	{

		$result = array();
		$result["error"] = true;

		$validator = Validator::make($request->all(), [
			'unique_id' => 'required',
		]);

		if($validator->fails()) {
			$result["message"] = "Parameters is missing.";
			return Response::json($result);
		}

		$unique_id = $request->input('unique_id');
		$customer = Customer::where('unique_id', '=', $unique_id)->first();

		// Customer not found.
		if (is_null($customer)) {
			$result["message"] = 'Customer not found.';
			return Response::json($result);
		}

		$member = $customer->members()->where('shop_id', '=', $id)->first();

		// Member not found.
		if (is_null($member)) {
			$result["message"] = 'Member not found.';
			return Response::json($result);
		}

		// Not a member yet.
		if ($member->is_member == false) {
			$result["message"] = 'Customer not found.';
			return Response::json($result);
		}

		// Clear
		$rewards = DB::table('rewards')
								->select('id', 'barcode', 'name', 'point_use', 'detail', 'image')
								->where('shop_id', '=', $id)
								->get();

		$result["error"] = false;
		$result["points"] = $member->point;
		$result["rewards"] = $rewards;

		return Response::json($result);

	}

	public function searchShop(Request $request)
	{

		$result = array();
		$result["found"] = false;

		$validator = Validator::make($request->all(), [
			'search' => 'required',
		]);

		if($validator->fails()) {
			$result["message"] = "Parameters is missing.";
			return Response::json($result);
		}

		$search_keyword = $request->input('search');

		$shops = DB::table('shops')
								->select('id', 'name', 'owner', 'image')
								->where('name', 'like', $search_keyword.'%')
								->where('is_branch', '=', false)
								->get();

		if(sizeof($shops) == 0) {
			$result["message"] = "Not Found.";
			return Response::json($result);
		}

		$result["found"] = true;
		$result["shops"] = $shops;

		return Response::json($result);

	}

	// End android application function.

  public function testGenerate() {
    $find = true;
    while($find) {
      $code = Generate::generateCode();
      $redeem = RedeemReward::where('code', '=', $code)->first();
      if( is_null($redeem) ) {
        $find = false;
      }
    }
    return $code;
  }

}
