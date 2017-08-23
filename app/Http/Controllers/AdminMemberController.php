<?php namespace App\Http\Controllers;

use DB;
use Session;
use App\Member;
use App\RedeemReward;
use App\PointHistory;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminMemberController extends Controller {

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

		$members = Member::all();
		return view('admin.members.index', compact('members'));

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

		$member = Member::find($id);
		$redeems = $member->redeemHistories()->get();
		$pointHistories = DB::table('point_histories')
									->select('*')
									->where('member_id', '=', $member->id)
									->orderBy('id', 'desc')
									->get();

		return view('admin.members.show', compact('member', 'redeems', 'pointHistories'));

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

		$member = Member::find($id);
		$member->delete();

		return 'success';

	}

}
