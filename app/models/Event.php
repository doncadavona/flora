<?php

/*
 * Notice: Event class is reserved by Laravel.
 * To use another Event class, change Event alias in app/config.
 */

class Event extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	public function portions()
	{
		return $this->hasMany('Portion');
	}

	public function contestants()
	{
		return $this->hasMany('Contestant');
	}

	public function state()
	{
		return $this->hasOne('State', 'event_id');
	}

	public function ratings()
	{
		return $this->hasMany('Rating');
	}
}