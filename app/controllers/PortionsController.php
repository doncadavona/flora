<?php

class PortionsController extends BaseController {

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

    	$portions = Portion::all();

    	$this->layout->content = View::make('admin.portions.index')->with('portions', $portions);
    }

    public function getCreate()
    {
        //

        $events = Event::all();
        $this->layout->content = View::make('admin.portions.create')->with('events', $events);
    }

    public function postCreate()
    {
        //

        $rules = array(
                'event'         => 'required|numeric',
                'name'          => 'required|min:2|max:100|unique:portions,name',
                'points'        => 'required|numeric|between:0,100',
                'description'   => 'min:1|max:1000',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::to('/admin/events/portions/create')
                ->withErrors($validator)
                ->withInput();
        }

        // save to database

        $portion = new Portion;
        $portion->event_id          = Input::get('event');
        $portion->name              = Input::get('name');
        $portion->points            = Input::get('points');
        $portion->description       = Input::get('description');

        if(!$portion->save())
        {
            // save failed

            return Redirect::to('/admin/events/portions/create')->withInput();
        }

        // success

        return Redirect::to('/admin/events/portions');
    }

    public function getEdit($id)
    {
        //

        $events = Event::all();
        $portion = Portion::find($id);
        $this->layout->content = View::make('admin.portions.edit')
            ->with('events', $events)
            ->with('portion', $portion);
    }

    public function postEdit($id)
    {
        //

        $rules = array(
                'event'         => 'required|numeric',
                'name'          => 'required|min:2|max:100|unique:portions,name,'.$id,
                'points'        => 'required|numeric|between:0,100',
                'description'   => 'min:1|max:1000',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::to('/admin/events/portions/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        // save to database

        $portion = Portion::find($id);
        $portion->event_id          = Input::get('event');
        $portion->name              = Input::get('name');
        $portion->points            = Input::get('points');
        $portion->description       = Input::get('description');

        if(!$portion->save())
        {
            // save failed

            return Redirect::to('/admin/events/portions/'.$id.'/edit')->withInput();
        }

        // success

        // check and use return url if  present

        return Redirect::to(Input::get('returnUrl') ?: '/admin/events/portions');
    }

    public function getDelete($id)
    {
        // delete account

        try{
            Portion::destroy($id);
        }
        catch(Exception $e){
            return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
        }

        return Redirect::to(Input::get('returnUrl') ?: '/admin/events/portions');
    }

    /*
     * api
     */

    public function postCreateApi()
    {
        //

        $array_response = array();

        $rules = array(
                'event_id'      => 'required|numeric',
                'name'          => 'required|min:2|max:100|unique:portions,name',
                'points'        => 'required|numeric|between:0,100',
                'description'   => 'min:1|max:1000',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            // return Redirect::to('/admin/events/portions/create')
            //     ->withErrors($validator)
            //     ->withInput();

            array_push($array_response, array('status' => 'INVALID_INPUT', 'message' => 'Invalid input provided.'));
            array_push($array_response, $validator->messages());

            return Response::json($array_response);
        }

        // save to database

        $portion = new Portion;
        $portion->event_id          = Input::get('event_id');
        $portion->name              = Input::get('name');
        $portion->points            = Input::get('points');
        $portion->description       = Input::get('description');

        if(!$portion->save())
        {
            // save failed

            array_push($array_response, array(
                    'status'    => 'SERVER_ERROR',
                    'message'   => 'Server error. Please retry later.'
                ));

            return Response::json($array_response);
        }

        // success

        array_push($array_response, array(
                    'status'    => 'SUCCESS',
                    'message'   => 'Item saved successfully..'
                ));
        return Response::json($array_response);
    }
}