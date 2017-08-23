<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $table = 'products';

	protected $fillable = [
		'shop_id',
		'barcode',
		'name',
		'price',
		'point',
		'has_promotion',
		'promotion_price',
		'promotion_point',
		'detail',
		'image',
		'promotion_start',
		'promotion_end'
	];

	// Products owned by shop.
	public function owner()
	{
		return $this->belongsTo('App\Shop', 'shop_id');
	}

}
