<?php

class Judge extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'judges';

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function event()
	{
		return $this->belongsTo('Event');
	}
}