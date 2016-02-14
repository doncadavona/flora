<?php

class JudgesController extends BaseController {

	/**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
    	//

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
    	//

    	$judges = Judge::all();

    	$this->layout->content = View::make('admin.judges.index')->with('judges', $judges);
    }

    public function getCreate()
    {
    	//
    	
    	if(Input::get('event_id') != null)
    		$events = Event::find(Input::get('event_id'));
    	else	
    		$events = Event::all();

    	$users = User::where('role_id', 3)->get();
    	
    	$this->layout->content = View::make('admin.judges.create')
    		->with('events', $events)
    		->with('users', $users);
    }

    public function postCreate()
    {
    	//

    	$rules = array(
				'user' => 'required|numeric',
				'event' => 'required|numeric'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/judges/create')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		$judge = new Judge;
		$judge->user_id 	= Input::get('user');
		$judge->event_id 	= Input::get('event');

		if(!$judge->save())
		{
			// save failed

			return Redirect::to('/admin/judges/create')->withInput();
		}

		// success

		// return Redirect::to('/admin/contestants');
		return Redirect::to(Input::get('returnUrl') ?: '/admin/judges');
    }

    public function getEdit($id)
    {
    	//

    	$judge = Judge::find($id);
    	$events = Event::all();
    	$this->layout->content = View::make('admin.judges.edit')
    		->with('judge', $judge)
    		->with('events', $events);
    }

    public function postEdit($id)
    {
    	//

    	$rules = array(
				'event'				=> 'required|numeric',
				'first_name' 		=> 'required|min:2|max:100',
				'middle_name' 		=> 'min:1|max:100',
				'last_name' 		=> 'required|min:2|max:100',
				'birth_date'		=> 'date',
				'gender'			=> 'required|alpha|min:4|max:6'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/jduges/'.$id.'/edit')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		// add to People
		$person = People::find(Judge::find($id)->id);
		$person->first_name 	= Input::get('first_name');
		$person->middle_name 	= Input::get('middle_name');
		$person->last_name 		= Input::get('last_name');
		if(Input::get('birth_date') != null)
			$person->birth_date = Input::get('birth_date');
		else
			$person->birth_date = null;
		$person->gender			= Input::get('gender');
		$person->save();

		$judge = Judge::find($id);
		$judge->person_id 			= $person->id;
		$judge->event_id 			= Input::get('event');

		if(!$judge->save())
		{
			// save failed

			return Redirect::to('/admin/judges/create')->withInput();
		}

		// success

		return Redirect::to(Input::get('returnUrl') ?: '/admin/judges');
    }

    public function getDelete($id)
	{
		// delete account

		try{
			Judge::destroy($id);
		}
		catch(Exception $e){
			return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
		}

		return Redirect::to('/admin/judges');
	}
}