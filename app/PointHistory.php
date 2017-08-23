<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model {

	protected $table = 'point_histories';

	protected $fillable = [
		'member_id',
		'point',
		'is_add',
		'detail'
	];

	public $timestamps = false;

}
