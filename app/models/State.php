<?php

/*
 * Notice: Event class is reserved by Laravel.
 * To use another Event class, change Event alias in app/config.
 */

class State extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'states';

	public $timestamps = false;

	public function event()
	{
		return $this->belongsTo('Event');
	}

	public function portion()
	{
		return $this->belongsTo('Portion', 'current_portion_id');
	}

	public function contestant()
	{
		return $this->belongsTo('Contestant', 'current_contestant_id');
	}
}