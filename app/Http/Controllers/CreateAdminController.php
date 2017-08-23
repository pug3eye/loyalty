<?php namespace App\Http\Controllers;

use App\Admin;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CreateAdminController extends Controller {

	public function createAdmin()
	{

		Admin::create([
			'username' => 'admin',
			'password' => bcrypt('admin')
		]);

		return 'success';

	}

}
