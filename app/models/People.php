<?php

class People extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'people';

	public $timestamps = true;

	public function municipality()
	{
		return $this->belongsTo('Municipality');
	}

	public function user()
	{
		return $this->hasOne('User');
	}

	public function contestant()
	{
		return $this->hasMany('Contestant');
	}

	public function judge()
	{
		return $this->hasMany('Judge');
	}

}