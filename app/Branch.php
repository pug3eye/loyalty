<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

	protected $table = 'branches';

	protected $fillable = [
		'main_id',
		'sub_id',
		'name'
	];

	public $primaryKey = 'sub_id';
	public $incrementing = false;
	public $timestamps = false;

	public function shop()
	{
		return $this->belongsTo('App\Shop', 'sub_id');
	}

}
