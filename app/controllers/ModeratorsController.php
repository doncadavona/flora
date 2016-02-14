<?php

class ModeratorsController extends BaseController {

	/**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth_admin', array('except' => 'getLogin'));

        $this->beforeFilter('csrf', array('on' => 'post'));

        // $this->afterFilter('log', array('only' =>
        //                     array('fooAction', 'barAction')));
    }

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.sb-admin-2';

	public function getIndex()
	{
		// display all moderators

		$moderators = User::where('role_id', 2)->get();

		$this->layout->content = View::make('admin.moderators.index')
			->with('moderators', $moderators);
	}
}
