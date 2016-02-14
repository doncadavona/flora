<?php

class CriteriaController extends BaseController {

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

    	$criteria = Criteria::all();

    	$this->layout->content = View::make('admin.criteria.index')->with('criteria', $criteria);
    }

    public function getCreate($event_id)
    {
        //

        $event = Event::find($event_id);
        $portions = Portion::all();
        $this->layout->content = View::make('admin.criteria.create')
            ->with('event', $event)
            ->with('portions', $portions);
    }

    public function postCreate($event_id)
    {
        //

        $rules = array(
                'portion'       => 'required|numeric',
                'name'          => 'required|min:2|max:100|unique:portions,name',
                'points'        => 'required|numeric|between:0,100',
                'description'   => 'max:1000',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::to('/admin/events/'.$event_id.'/criteria/create')
                ->withErrors($validator)
                ->withInput();
        }

        // save to database

        $criterion = new Criteria;
        $criterion->portion_id        = Input::get('portion');
        $criterion->name              = Input::get('name');
        $criterion->points            = Input::get('points');
        $criterion->description       = Input::get('description');

        if(!$criterion->save())
        {
            // save failed

            return Redirect::to('/admin/events/'.$event_id.'/criteria/create')->withInput();
        }

        // success

        return Redirect::to('/admin/events/'.$event_id);

    }

    public function getEdit($event_id, $criterion_id)
    {
        //

        $event = Event::find($event_id);
        $portion = Portion::find(Criteria::find($criterion_id)->portion->id);
        $criterion = Criteria::find($criterion_id);

        $this->layout->content = View::make('admin.criteria.edit')
            ->with('event', $event)
            ->with('portion', $portion)
            ->with('criterion', $criterion);
    }

    public function postEdit($event_id, $criterion_id)
    {
        //

        $rules = array(
                'portion'       => 'required|numeric',
                'name'          => 'required|min:2|max:100|unique:portions,name',
                'points'        => 'required|numeric|between:0,100',
                'description'   => 'max:1000',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::to('/admin/events/'.$event_id.'/criteria/'.$criterion_id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        // save to database

        $criterion = Criteria::find($criterion_id);
        $criterion->portion_id        = Input::get('portion');
        $criterion->name              = Input::get('name');
        $criterion->points            = Input::get('points');
        $criterion->description       = Input::get('description');

        if(!$criterion->save())
        {
            // save failed

            return Redirect::to('/admin/events/'.$event_id.'/criteria/'.$criterion_id.'/edit')->withInput();
        }

        // success

        // return Redirect::to('/admin/events/'.$event_id);
        return Redirect::to(Input::get('returnUrl') ?: '/admin/events/'.$event_id);

    }

    public function getDelete($event_id, $criterion_id)
    {
        // delete object

        try{
            Criteria::destroy($criterion_id);
        }
        catch(Exception $e){
            return 'Something went wrong...<hr/>Exception catched:<br/>'.$e; 
        }

        return Redirect::to('/admin/events/'.$event_id);
    }

}
