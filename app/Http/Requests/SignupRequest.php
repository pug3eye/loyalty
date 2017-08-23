<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SignupRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'required|unique:shops|min:6|max:100',
			'password' => 'required|min:6',
			'password_confirmation' => 'required|min:6',
			'email' => 'required|unique:shops|email|max:100',
			'owner' => 'required|max:100',
			'name' => 'required|unique:shops|max:100'
		];
	}

}
