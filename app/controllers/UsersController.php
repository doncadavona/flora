<?php

class UsersController extends BaseController {

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
		// display all users

		$users = User::all();

		$this->layout->content = View::make('admin.users.index')
			->with('users', $users);
	}

	// create or register a user
	public function getCreate()
	{
		// show form for creating a user

		// get roles for role selection

		$roles = Role::all();

		$this->layout->content = View::make('admin.users.create')
			->with('roles', $roles);
	}

	public function postCreate()
	{
		//

		// get and validate input

		$rules = array(
				'role'				=> 'required|numeric|between:1,4',
				'username' 			=> 'required|alpha_num|unique:users,username',
		        'password' 			=> 'required|min:6',
		        'password_confirm'	=> 'required|same:password',
		        
		        'first_name' 		=> 'min:2',
		        'middle_name' 		=> 'min:1',
		        'last_name' 		=> 'min:2',
		        'birth_date' 		=> 'date',
		        'gender' 			=> 'alpha|min:4|max:6',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/users/create')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		// add to person if person's info is set

		if(    Input::get('first_name')
			|| Input::get('middle_name')
			|| Input::get('last_name')
			|| Input::get('municipality_id')
			|| Input::get('birth_date')
			|| Input::get('gender')
		)
		{
			$person = new People;

			$person->municipality_id 	= Input::get('municipality');
			$person->first_name 		= Input::get('first_name');
			$person->middle_name 		= Input::get('middle_name');
			$person->last_name 			= Input::get('last_name');
			$person->birth_date 		= Input::get('birth_date');
			$person->gender 			= Input::get('gender');

			$person->save();
		}

		$user = new User;

		$user->role_id 		= Input::get('role');
		$user->username 	= Input::get('username');
		$user->password 	= Hash::make(Input::get('password'));

		// save peron's id if person was set
		if(isset($person))
		{
			$user->person_id = $person->id;
		}

		if(Auth::user()->role->id == 1)
			$user->verified = 1;
		else
			$user->verified = 0;

		if(!$user->save())
		{
			// save failed

			return Redirect::to('/admin/users/create')->withInput();
		}

		// success

		return Redirect::to('/admin/users');
	}

	public function getShow()
	{
		//
	}

	public function getEdit()
	{
		//
		$user = User::find(Route::input('id'));
		$this->layout->content = View::make('admin.users.edit')
			->with('user', $user);
	}

	public function postEdit($id)
	{
		//
		// get and validate input

		$rules = array(
		        'role'		=> 'required|numeric|between:1,4',
		        'username' 	=> 'required|alpha_num|unique:users,username,'.Route::input('id')
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/users/'.$id.'/edit/')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		// add to person if person's info is set

		if(    Input::get('first_name')
			|| Input::get('middle_name')
			|| Input::get('last_name')
			|| Input::get('municipality_id')
			|| Input::get('birth_date')
			|| Input::get('gender')
		)
		{
			if(isset(User::find($id)->person))
				$person = People::find(User::find($id)->person->id);
			else
				$person = new People;

			$person->municipality_id 	= Input::get('municipality');
			$person->first_name 		= Input::get('first_name');
			$person->middle_name 		= Input::get('middle_name');
			$person->last_name 			= Input::get('last_name');
			$person->birth_date 		= Input::get('birth_date');
			$person->gender 			= Input::get('gender');

			$person->save();
		}

		$user = User::find(Route::input('id'));

		$user->role_id 	= Input::get('role');
		$user->username = Input::get('username');

		// save peron's id if person was set
		if(isset($person))
		{
			$user->person_id = $person->id;
		}

		if(!$user->save())
		{
			// failed to save to the database

			return Redirect::to('/admin/users')->withInput();
		}

		// success

		return Redirect::to('/admin/');
	}

	// toggle aprroval status of self-registered users
	public function getToggleApproval()
	{
		//
		$user = User::find(Route::input('id'));

		// approve user
		if($user->verified == 0)
			$user->verified = 1;
		else
			$user->verified = 0;

		if(!$user->save())
		{
			// failed to save to the database

			return Redirect::to('/admin/users')->withInput();
		}

		// success

		return Redirect::to('admin/users');
	}

	public function getDelete($id)
	{
		// delete account

		try{
			User::destroy($id);
		}
		catch(Exception $e){
			return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
		}

		return Redirect::to('/admin/users');
	}


}
