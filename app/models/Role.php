<?php

class Role extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	public $timestamps = false;

	public function user()
	{
		return $this->hasMany('User');
	}
}