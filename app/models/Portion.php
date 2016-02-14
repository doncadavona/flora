<?php

class Portion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'portions';

	public function event()
	{
		return $this->belongsTo('Event');
	}

	public function criteria()
	{
		return $this->hasMany('Criteria');
	}

	public function state()
	{
		return $this->hasOne('State', 'current_portion_id');
	}

	public function ratings()
	{
		return $this->hasMany('Rating');
	}
}