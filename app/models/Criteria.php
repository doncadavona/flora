<?php

class Criteria extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'criteria';

	public $timestamps = false;

	public function portion()
	{
		return $this->belongsTo('Portion');
	}

	public function ratings()
	{
		return $this->hasMany('Rating', 'criterion_id');
	}
}