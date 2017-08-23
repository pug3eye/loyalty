<?php namespace App\Http\Controllers;

use DB;
use Auth;
use App\Shop;
use App\Member;
use App\Reward;
use App\CheckBranch;
use App\RedeemReward;
use App\PointHistory;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\RewardRequest;
use App\Http\Requests\EditRewardRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RewardController extends Controller {

	// Display a listing of the rewards.
	public function index()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		// check is branch or not.
		// if branch, get main branch id and get rewards of main branch.
		// else get auth user.
		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// get rewards owned by auth user or rewards of main branch.
		$rewards = $user->rewards;

		return view('rewards.index', compact('rewards'));

	}

	// Show form for creating a new reward.
	public function create()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		if ( CheckBranch::isBranch() ) {
			return redirect()->back();
		}

		return view('rewards.add');

	}

	// Store a newly created reward in storage.
	public function store(RewardRequest $request)
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

		// check reward bardcode is unique for auth user or not.
		// null if not found.
		$checkReward = $user->rewards->where('barcode', $input['code'])->first();
		if ( !is_null($checkReward) ) {
			// not null value.
			return redirect()->back()->with('error_barcode', "Error")->withInput();
		}

		// create reward object to store.
		$reward = new Reward;
		$reward->shop_id = $user_id;
		$reward->barcode = $input['code'];
		$reward->name = $input['name'];
		$reward->point_use = $input['point_use'];
		$reward->detail = $input['detail'];

		// check input have image or not.
		if( $file != NULL ) {
			// have image. set new name for image.
			// move image to prefer directory and store image name in database.
			$path = 'images/rewards';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$user_id. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$reward->image = $filename;
		} else {
			$reward->image = 'no_image.png';
		}

		// store data success.
		if ( $reward->save() == TRUE ) {
			// move back to add reward page with some feedback.
			return redirect('reward/add')->with('flash_message', "Success");
		}

		// some error occurs.
		return redirect('reward/add')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	// Display the specified reward.
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

		// find reward.
		$reward = $user->rewards->find($id);

		// if not found redirect back
		if ( is_null($reward) ) {
			return redirect()->back();
		}

		// return response()->json($reward);
		return view('rewards.show', compact('reward'));

	}

	// Show the form for editing the specified rewards.
	public function edit($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		// get auth user.
		$user = Auth::user();
		// get specified reward.
		$reward = $user->rewards->find($id);

		if ( is_null($reward) ) {
			return redirect()->back();
		}

		return view('rewards.edit', compact('reward'));

	}

	// Update the specified reward in storage.
	public function update(EditRewardRequest $request, $id)
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
		$reward = $user->rewards->find($id);

		if ( is_null($reward) ) {
			return redirect()->back();
		}

		// Update data.
		$reward->name = $input['name'];
		$reward->point_use = $input['point_use'];
		$reward->detail = $input['detail'];

		// check input have image or not.
		if ( $file != NULL ) {

			// have input image.

			// check reward already have image or not.
			if( strcmp($reward->image, 'no_image.png') ) {

				// already have.
				// delete old image.
				$old_file_name = $reward->image;
				$public_path = public_path('images/rewards/');
				$file_path = $public_path.$old_file_name;
				unlink($file_path);

			}

			$path = 'images/rewards';
			$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$filename = $timestamp. '-' .$user['id']. '-' .$file->getClientOriginalName();
			$file->move($path, $filename);
			$reward->image = $filename;

		}

		// update data.
		if ( $reward->save() == TRUE ) {
			// move back to index page with some feedback.
			return redirect('reward')->with('flash_message', "edit success");
		}

		// some error occurs.
		return redirect('reward')->with('error_message', "Oops !! Some errors have occur. Please try again !! ");

	}

	// Remove the specified reward from storage.
	public function destroy($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		// get auth user.
		$user = Auth::user();
		// get reward by id
		$reward = $user->rewards->find($id);
		// get image name.
		$file_name = $reward->image;

		if ( is_null($reward) ) {
			return redirect()->back();
		}

		// check reward has image or not.
		if( strcmp($file_name, 'no_image.png') ) {
			// has image
			$public_path = public_path('images/rewards/');
			$file_path = $public_path.$file_name;
			unlink($file_path);
		}

		$reward->delete();

		return 'success';

	}

	// Remove only image of specified reward.
	public function destroyImage($id)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		// get auth user.
		$user = Auth::user();

		// get reward owned by user and find with id.
		$reward = $user->rewards->find($id);

		if ( is_null($reward) ) {
			return 'fail';
		}

		// get image name.
		$file_name = $reward->image;

		// delete image.
		$public_path = public_path('images/rewards/');
		$file_path = $public_path.$file_name;
		unlink($file_path);

		// set to default value and update.
		$reward->image = 'no_image.png';
		$reward->save();

		return 'success';

	}

	// show all redeem reward histories of shop.
	public function redeemHistories()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		// get auth user.
		// $user = Auth::user();

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$histories = DB::table('redeem_rewards')
									->join('rewards', 'redeem_rewards.reward_id', '=', 'rewards.id')
									->join('members', 'redeem_rewards.member_id', '=', 'members.id')
									->join('customers', 'members.customer_id', '=', 'customers.id')
									->join('shops', 'shops.id', '=', 'rewards.shop_id')
									->select('redeem_rewards.member_id', 'redeem_rewards.reward_id', 'redeem_rewards.created_at', 'rewards.name', 'customers.firstname', 'customers.lastname')
									->where('rewards.shop_id', '=', $user->id)
									->where('redeem_rewards.used', '=', true)
									->orderBy('redeem_rewards.created_at', 'desc')
									->get();

		return view('rewards.history', compact('histories'));

	}

	public function showRedeem()
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return redirect('login');
		}

		return view('redeems.index');

	}

	public function redeem(Request $request)
	{

		// check is auth or not.
		if ( Auth::guest() ) {
			return 'guest';
		}

		$code = $request->input('code');

		// get auth user.
		// $user = Auth::user();

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		// find redeem_reward with code.
		// $redeem = RedeemReward::where('code', '=', $code)->where('used', '=', false)->first();
		$redeem = DB::table('redeem_rewards')
								->join('rewards', 'redeem_rewards.reward_id', '=', 'rewards.id')
								->select('redeem_rewards.id')
								->where('redeem_rewards.code', '=', $code)
								->where('redeem_rewards.used', '=', false)
								->where('rewards.shop_id', '=', $user->id)
								->first();

		// check is code valid or not.
		if( is_null($redeem) ) {

			// not valid.
			return 'error';

		} else {

			$redeem_transaction = RedeemReward::find($redeem->id);

			// valid.
			$time = Carbon::now();

			// get member and reward detail.
			$member = Member::find($redeem_transaction->member_id);
			$reward = Reward::find($redeem_transaction->reward_id);

			// update point of member and save.
			$newPoint = $member->point - $reward->point_use;
			$member->point = $newPoint;
			$member->save();

			// create point history of member.
			$pointHistory = new PointHistory;
			$pointHistory->member_id = $member->id;
			$pointHistory->point = $reward->point_use;
			$pointHistory->is_add = false;
			$pointHistory->detail = 'redeem reward "'.$reward->name.'"';
			$pointHistory->created_at = $time;
			$pointHistory->save();

			// change code is use.
			$redeem_transaction->used = true;
			$redeem_transaction->created_at = $time;
			$redeem_transaction->save();

			return $reward->barcode.' '.$reward->name;

		}

	}

	public function redeemResult(Request $request)
	{

		$code = $request->input('code');

		if ( CheckBranch::isBranch() ) {
			$main_id = CheckBranch::mainShopId();
			$user = Shop::find($main_id);
		} else {
			$user = Auth::user();
		}

		$redeem = RedeemReward::where('code', '=', $code)->where('used', '=', true)->first();

		$redeem_transaction = RedeemReward::find($redeem->id);
		$member = Member::find($redeem_transaction->member_id);
		$reward = Reward::find($redeem_transaction->reward_id);

		// $result = array();
		// $result['name'] = $member->customer()->firstname.' '.$member->customer()->lastname;
		// $result['old_point'] = $member->point + $reward->point;
		// $result['new_point'] = $member->point;

		return view('redeems.result', compact('member', 'reward'));
		
	}

}
