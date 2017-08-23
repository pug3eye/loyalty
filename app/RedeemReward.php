<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemReward extends Model {

	protected $table = 'redeem_rewards';

	protected $fillable = [
		'member_id',
		'reward_id',
		'code',
		'used'
	];

	public $timestamps = false;

	public function member()
	{
		return $this->belongsTo('App\Member');
	}

	public function reward()
	{
		return $this->belongsTo('App\Reward');
	}

}
