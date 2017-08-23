<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Shop extends Model implements AuthenticatableContract {

	use Authenticatable;
	// use CanResetPassword;

	protected $table = 'shops';

	protected $fillable = [
		'username',
		'password',
		'is_branch',
		'email',
		'owner',
		'name'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	// Shop can have many members.
	public function members()
	{
		return $this->hasMany('App\Member');
	}

	// Shop can have many products.
	public function products()
	{
		return $this->hasMany('App\Product');
	}

	// Shop can have many rewards.
	public function rewards()
	{
		return $this->hasMany('App\Reward');
	}

	// Show branches of this shop.
	public function branches()
	{
		return $this->hasMany('App\Branch', 'main_id');
	}

}
