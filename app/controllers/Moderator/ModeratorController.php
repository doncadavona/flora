<?php

class ModeratorController extends BaseController {

	/**
     * Instantiate a new ModeratorController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth_moderator', array('except' => 'getLogin'));

        $this->beforeFilter('csrf', array('on' => 'post'));

        // $this->afterFilter('log', array('only' =>
        //                     array('fooAction', 'barAction')));
    }

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.moderator.layout';

    public function getIndex()
    {
    	//

        $events = Event::all();
    	$this->layout->content = View::make('moderator.index')->with('events', $events);
    }

    public function getShow($event_id)
    {
        //

        $event = Event::find($event_id);
        $event_state = $event->state;
        $portions = $event->portions;
        $contestants = $event->contestants;

        $this->layout->content = View::make('moderator.show')
            ->with('event', $event)
            ->with('event_state', $event_state)
            ->with('portions', $portions)
            ->with('contestants', $contestants);
    }

    public function postApiToggleStart($event_id)
    {
        // start the event

        $event = Event::find($event_id);
        $event_state = $event->state;

        if($event_state->event_status == 'UNSTARTED')
        {
            $event_state->event_status = 'STARTED';
        }
        else if($event_state->event_status == 'STARTED' || $event_state->event_status == 'PAUSED')
        {
            $event_state->event_status = 'ENDED';
            $event_state->current_portion_id = null;
            $event_state->current_contestant_id = null;
        }
        
        if($event_state->save())
        {
            // return 'SUCCESS';
            return Response::json(array('msg' => 'SUCCESS', 'event_status' => $event_state->event_status));
        }
        else
        {
            return Response::json(array('msg' => 'FAILED', 'event_status' => $event_state->event_status));
        }
    }

    public function postApiTogglePause($event_id)
    {
        // start the event

        $event = Event::find($event_id);
        $event_state = $event->state;

        if($event_state->event_status == 'STARTED')
        {
            $event_state->event_status = 'PAUSED';
            $event_state->current_portion_id = null;
            $event_state->current_contestant_id = null;
        }
        else if($event_state->event_status == 'PAUSED')
        {
            $event_state->event_status = 'STARTED';
        }

        if($event_state->save())
        {
            return Response::json(array('msg' => 'SUCCESS', 'event_status' => $event_state->event_status));
        }
        else
        {
            return Response::json(array('msg' => 'FAILED', 'event_status' => $event_state->event_status));
        }
    }

    public function postResetEvent($event_id)
    {
        // start the event

        $event = Event::find($event_id);
        $event_state = $event->state;

        $event_state->current_portion_id = null;
        $event_state->current_contestant_id = null;
        $event_state->event_status = 'UNSTARTED';

        if($event_state->save())
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
        else
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
    }

    public function postApiSetCurrentPortion($event_id)
    {
        // set current portion from portion id

        $event = Event::find($event_id);
        $event_state = $event->state;

        $event_state->current_portion_id = Input::get('radioPortion');

        if($event_state->save())
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
        else
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
    }

    public function postApiSetCurrentContestant($event_id)
    {
        // set current portion from portion id

        $event = Event::find($event_id);
        $event_state = $event->state;

        $event_state->current_contestant_id = Input::get('radioContestant');

        if($event_state->save())
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
        else
        {
            return Redirect::to('/moderator/events/'.$event_id);
        }
    }
}