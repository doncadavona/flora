<?php

class Municipality extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'municipalities';

	public $timestamps = false;

	public function contestants()
	{
		return $this->hasMany('Contestant');
	}
}