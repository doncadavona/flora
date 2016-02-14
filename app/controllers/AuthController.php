<?php

class AuthController extends BaseController {

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.public';

	public function getRegister()
	{
		$this->layout->content = View::make('register');
	}

	public function postRegister()
	{
		// get and validate input

		$rules = array(
		        'name' 				=> 'required|min:3',
		        'email' 			=> 'required|email|unique:users,email',
		        'password' 			=> 'required|min:6',
		        'password_confirm'	=> 'required|same:password'
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('register')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		$user = new User;

		$user->role = 'registrant';
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->verified = 0;

		if(!$user->save())
		{
			// failed to save to the database

			return Redirect::to('register')->withInput();
		}

		// success

		// login the user
		Auth::loginUsingId($user->id);
		return Redirect::to('profile');

	}

	public function getLogin()
	{
		if(!Auth::check())
			$this->layout->content = View::make('login');
		else
			return Redirect::to('/profile');
	}

	public function postLogin()
	{
		// authenticate user

		if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
		{
			// success

			if(Auth::user()->role_id == 1)
		    	return Redirect::intended('/admin');
		    
		    if(Auth::user()->role_id == 2)
		    	return Redirect::intended('/moderator');
		    if(Auth::user()->role_id == 3)
		    	return Redirect::intended('/judge');
		    if(Auth::user()->role_id == 4)
		    	return Redirect::intended('/scoreboard');
		}

		return Redirect::to('/login')->withInput();
	}

	public function postLogout()
	{
		Auth::logout();
		return Redirect::to('/login');
	}
}