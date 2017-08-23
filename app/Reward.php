<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model {

	protected $table = 'rewards';

	protected $fillable = [
		'shop_id',
		'barcode',
		'name',
		'point_use',
		'detail',
		'image'
	];

	// Rewards owned by shop.
	public function owner()
	{
		return $this->belongsTo('App\Shop', 'shop_id');
	}

	public function redeemRewards()
	{
		return $this->hasMany('App\RedeemReward');
	}

}
