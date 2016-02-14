<?php

class ProfileController extends BaseController {

	/**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth', array('except' => 'getLogin'));

        $this->beforeFilter('csrf', array('on' => 'post'));

        // $this->afterFilter('log', array('only' =>
        //                     array('fooAction', 'barAction')));
    }

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.public';

	public function getIndex()
	{
		$user = Auth::user();
		$this->layout->content = View::make('profile.index')->with('user', $user);
	}

	public function getEdit()
	{
		$user = Auth::user();
		$this->layout->content = View::make('profile.edit')->with('user', $user);
	}

	public function postEdit()
	{
		// get and validate input

		$rules = array(
		        'name' 				=> 'required|min:3',
		        'email' 			=> 'required|email|unique:users,email,'.Auth::user()->id
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/profile/edit')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		$user = User::find(Auth::user()->id);

		$user->name = Input::get('name');
		$user->email = Input::get('email');

		if(!$user->save())
		{
			// failed to save to the database

			return Redirect::to('/profile/edit')->withInput();
		}

		// success

		return Redirect::to('profile');
	}

	public function getChangePassword()
	{
		$this->layout->content = View::make('profile.change-password');
	}

	public function postChangePassword()
	{
		//
		$rules = array(
		        'new_password' 			=> 'required|min:6',
		        'new_password_confirm'	=> 'required|same:new_password'
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/profile/change-password')
		    	->withErrors($validator);
		}

		// save to database

		$user = User::find(Auth::user()->id);

		$user->password = Hash::make(Input::get('new_password'));

		if(!$user->save())
		{
			// failed to save to the database

			return Redirect::to('register')->withInput();
		}

		// success

		return Redirect::to('/profile');
	}

	public function getDelete()
	{
		// delete account

		if(User::destroy(Auth::user()->id))
		{
			Auth::logout();
			return Redirect::to('login');
		}

		return 'Something went wrong...';
	}

}