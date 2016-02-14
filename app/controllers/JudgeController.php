<?php

class JudgeController extends BaseController {

	/**
     * Instantiate a new ModeratorController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth_judge', array('except' => 'getLogin'));

        $this->beforeFilter('csrf', array('on' => 'post'));

        // $this->afterFilter('log', array('only' =>
        //                     array('fooAction', 'barAction')));
    }

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.judge.layout';

    public function getIndex()
    {
        //

        // get the events that the judge is assigned to judge

        $event = AUth::user()->judge->event;
        $this->layout->content = View::make('judge.index')
            ->with('event', $event);
    }

    public function getShow($event_id)
    {
        //

        $event = Event::find($event_id);

        // get contestants from each municipality

        $contestants = $event->contestants;
        $portions = $event->portions;
        $event_state = $event->state;

        View::share('brand', $event->name);

        $this->layout->content = View::make('judge.show')
            ->with('event', $event)
            ->with('contestants', $contestants)
            ->with('portions', $portions)
            ->with('event_state', $event_state);
    }

    public function postSetPoint($event_id)
    {
        //

        // first, check if rating already exist, else create new

        $rating = Rating::where('event_id', $event_id)
            ->where('portion_id', Input::get('portion'))
            ->where('criterion_id', Input::get('criterion'))
            ->where('contestant_id', Input::get('contestant'))
            ->first();

        if($rating != null)
        {
            // return Input::get('/judge/events/'.$event_id);

            return 'Already scored.';
        }

        $rating = new Rating;

        $rating->event_id = Input::get('event');
        $rating->portion_id = Input::get('portion');
        $rating->criterion_id = Input::get('criterion');
        $rating->contestant_id = Input::get('contestant');
        $rating->judge_id = Auth::user()->judge->id;

        $criterion = Criteria::find(Input::get('criterion'));

        // return preg_replace('/\s+/', '', $criterion->name);

        $rating->points = Input::get(preg_replace('/\s+/', '', $criterion->name));

        if(!$rating->save())
        {
            return 'Server error. Retry later.';
        }

        return Redirect::to('/judge/events/'.$event_id);

    }
}
