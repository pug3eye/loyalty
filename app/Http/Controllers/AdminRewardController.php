<?php namespace App\Http\Controllers;

use Session;
use App\Reward;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminRewardController extends Controller {

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

		$rewards = Reward::all();
		return view('admin.rewards.index', compact('rewards'));

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

		$reward = Reward::find($id);
		return view('rewards.show', compact('reward'));
		
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

		$reward = Reward::find($id);
		$file_name = $reward->image;

		if( strcmp($file_name, 'no_image.png') ) {
			$public_path = public_path('images/rewards/');
			$file_path = $public_path.$file_name;
			unlink($file_path);
		}

		$reward->delete();

		return 'success';

	}

}
