<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $table = 'customers';

	protected $fillable = [
		'username',
		'password',
		'firstname',
		'lastname',
		'email',
		'phone_number'
	];

	protected $hidden = [
		'password',
		'unique_id'
	];

	// Customer can have many members.
	public function members()
	{
		return $this->hasMany('App\Member');
	}

}
