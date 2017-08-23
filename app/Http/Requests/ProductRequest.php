<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request {

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
			'code' => 'required|regex:/^[0-9]+$/',
			'name' => 'required|max:200',
			'price' => 'required|numeric',
			'point' => 'required|integer',
			'promotion_price' => 'numeric',
			'promotion_point' => 'integer',
			'detail' => 'max:200',
			'start_date' => 'date',
			'end_date' => 'date',
			'image' => 'image'
		];
	}

}
