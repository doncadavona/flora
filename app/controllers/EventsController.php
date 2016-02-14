<?php

class EventsController extends BaseController {

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
    	//

    	$events = Event::all();
    	$this->layout->content = View::make('admin.events.index')->with('events', $events);
    }

    public function getCreate()
    {
    	//

    	$this->layout->content = View::make('admin.events.create');
    }

    public function postCreate()
    {
    	//

    	$rules = array(
				'name' 			=> 'required|min:2|max:100|unique:events,name',
				'description' 	=> 'min:2|max:1000',
				'date'			=> 'date',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/events/create')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		$event = new Event;

		$event->name 			= Input::get('name');
		$event->description 	= Input::get('description');
		if(Input::get('date') != null)
			$event->date 		= Input::get('date');
		else
			$event->date 		= null;
		if(!$event->save())
		{
			// save failed

			return Redirect::to('/admin/events/create')->withInput();
		}

		// create state object

		$event_state = new State;
		$event_state->event_id = $event->id;

		if(!$event_state->save())
		{
			return 'Oops! Server error.';
		}

		// all with success

		return Redirect::to('/admin/events');
    }

    public function getEdit($id)
    {
    	//

    	$event = Event::find($id);
    	$this->layout->content = View::make('admin.events.edit')->with('event', $event);
    }

    public function postEdit($id)
    {
    	//

    	$rules = array(
				'name' 			=> 'required|min:2|max:100|unique:events,name,'.$id,
				'description' 	=> 'min:2|max:1000',
				'date'			=> 'date',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
		    // The given data did not pass validation
		    return Redirect::to('/admin/events/'.$id.'/edit')
		    	->withErrors($validator)
		    	->withInput();
		}

		// save to database

		$event = Event::find($id);

		$event->name 			= Input::get('name');
		$event->description 	= Input::get('description');
		if(Input::get('date') != null)
			$event->date 			= Input::get('date');
		else
			$event->date = null;
		if(!$event->save())
		{
			// save failed

			return Redirect::to('/admin/events/create')->withInput();
		}

		// success

		return Redirect::to(Input::get('returnUrl') ?: '/admin/events');
    }

    public function getShow($id)
    {
    	//

    	$event = Event::find($id);
    	$portions = $event->portions()->get();
    	$criteria = Criteria::all();
    	$contestants = Contestant::all();
    	// $portions = Portion::where('event_id', '=', $event->id)->get();
    	$this->layout->content = View::make('admin.events.show')
    		->with('event', $event)
    		->with('portions', $portions)
    		->with('contestants', $contestants)
    		->with('criteria', $criteria);
    }

    public function getDelete($id)
	{
		// delete account

		try{
			Event::destroy($id);
		}
		catch(Exception $e){
			return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
		}

		return Redirect::to('/admin/events');
	}

	public function getModerators($id)
	{
		// get moderators from users table

		$moderators = User::where('rol');
	}
}