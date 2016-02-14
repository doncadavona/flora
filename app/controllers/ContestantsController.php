<?php

class ContestantsController extends BaseController {

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

    	$contestants = Contestant::all();

    	$this->layout->content = View::make('admin.contestants.index')->with('contestants', $contestants);
    }

    public function getCreate()
    {
    	//

    	$municipalities = Municipality::all();
    	
    	if(Input::get('event_id') != null)
    		$events = Event::find(Input::get('event_id'));
    	else	
    		$events = Event::all();
    	

    	$this->layout->content = View::make('admin.contestants.create')
    		->with('municipalities', $municipalities)
    		->with('events', $events);
    }

    public function postCreate()
    {
    	//

    	$rules = array(
				'municipality'		=> 'required|numeric|between:1,23',
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
		    return Redirect::to('/admin/contestants/create')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		// add to People
		$person = new People;
		$person->first_name 	= Input::get('first_name');
		$person->middle_name 	= Input::get('middle_name');
		$person->last_name 		= Input::get('last_name');
		if(Input::get('birth_date') != null)
			$person->birth_date = Input::get('birth_date');
		else
			$person->birth_date = null;
		$person->gender			= Input::get('gender');
		$person->save();

		$contestant = new Contestant;
		$contestant->person_id 			= $person->id;
		$contestant->municipality_id 	= Input::get('municipality');
		$contestant->event_id 			= Input::get('event_id') ?: Input::get('event');

		if(!$contestant->save())
		{
			// save failed

			return Redirect::to('/admin/contestants/create')->withInput();
		}

		// success

		// return Redirect::to('/admin/contestants');
		return Redirect::to(Input::get('returnUrl') ?: '/admin/contestants');
    }

    public function getEdit($id)
    {
    	//

    	$contestant = Contestant::find($id);
    	$municipalities = Municipality::all();
    	$events = Event::all();
    	$this->layout->content = View::make('admin.contestants.edit')
    		->with('contestant', $contestant)
    		->with('municipalities', $municipalities)
    		->with('events', $events);
    }

    public function postEdit($id)
    {
    	//

    	$rules = array(
				'municipality'		=> 'required|numeric|between:1,23',
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
		    return Redirect::to('/admin/contestants/'.$id.'/edit')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		// add to People
		$person = People::find(Contestant::find($id)->id);
		$person->first_name 	= Input::get('first_name');
		$person->middle_name 	= Input::get('middle_name');
		$person->last_name 		= Input::get('last_name');
		if(Input::get('birth_date') != null)
			$person->birth_date = Input::get('birth_date');
		else
			$person->birth_date = null;
		$person->gender			= Input::get('gender');
		$person->save();

		$contestant = Contestant::find($id);
		$contestant->person_id 			= $person->id;
		$contestant->municipality_id 	= Input::get('municipality');
		$contestant->event_id 			= Input::get('event');

		if(!$contestant->save())
		{
			// save failed

			return Redirect::to('/admin/contestants/create')->withInput();
		}

		// success

		return Redirect::to(Input::get('returnUrl') ?: '/admin/contestants');
    }

    public function getDelete($id)
	{
		// delete account

		try{
			Contestant::destroy($id);
		}
		catch(Exception $e){
			return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
		}

		return Redirect::to('/admin/contestants');
	}
}