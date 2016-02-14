<?php

class Rating extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ratings';

	public $timestamps = false;

	public function event()
	{
		return $this->belongsTo('Event');
	}

	public function portion()
	{
		return $this->belongsTo('Portion');
	}

	public function criterion()
	{
		return $this->belongsTo('Criteria');
	}

	public function contestant()
	{
		return $this->belongsTo('Contestant');
	}
}