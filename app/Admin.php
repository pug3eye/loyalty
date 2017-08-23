<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract {

	use Authenticatable;

	protected $table = 'admins';

	protected $fillable = ['username', 'password'];

	protected $hidden = ['password'];

	public $timestamps = false;

}
