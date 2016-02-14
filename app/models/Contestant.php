<?php

class Contestant extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contestants';

	public $timestamps = false;

	public function municipality()
	{
		return $this->belongsTo('Municipality');
	}

	public function person()
	{
		return $this->belongsTo('People');
	}

	public function event()
	{
		return $this->belongsTo('Event');
	}

	public function state()
	{
		return $this->hasOne('State', 'current_contestant_id');
	}

	public function ratings()
	{
		return $this->hasMany('Rating');
	}
}