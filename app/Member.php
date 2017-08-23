<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {

	protected $table = 'members';

	protected $fillable = [
		'customer_id',
		'shop_id',
		'point',
		'is_member'
	];

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function shop()
	{
		return $this->belongsTo('App\Shop');
	}

	public function redeemHistories()
	{
		return $this->hasMany('App\RedeemReward');
	}

}
