<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	if(Auth::check())
		return Redirect::to('/profile');
	else
		return Redirect::to('/login');
});

Route::get('pluralize', function()
{
	return 'Plural form of '.Input::get('noun').': '.str_plural(Input::get('noun'));
});

// log in
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

// logout
Route::post('logout', 'AuthController@postLogout');

// registration
Route::get('register', 'AuthController@getRegister');
Route::post('register', 'AuthController@postRegister');

// edit profile
Route::get('profile/edit', 'ProfileController@getEdit');
Route::post('profile/edit', 'ProfileController@postEdit');

// change password
Route::get('profile/change-password', 'ProfileController@getChangePassword');
Route::post('profile/change-password', 'ProfileController@postChangePassword');

// delete profile
Route::get('profile/delete', 'ProfileController@getDelete');
Route::get('profile', 'ProfileController@getIndex');

// admin
Route::group(array('prefix' => 'admin'), function()
{
	// index of admin
	Route::get('/', function()
	{
		return Redirect::to('/admin/users');
	});

	// eg.: /admin/users
    Route::group(array('prefix' => 'users'), function()
	{
	    Route::get('{id}/edit', 'UsersController@getEdit');
	    Route::post('{id}/edit', 'UsersController@postEdit');
	    Route::get('{id}/toggle-approval', 'UsersController@getToggleApproval');
	    Route::get('{id}/delete', 'UsersController@getDelete');
	    Route::get('create', 'UsersController@getCreate');
	    Route::post('create', 'UsersController@postCreate');
	    Route::get('/', 'UsersController@getIndex');
	});

    // admin/contestants
	Route::group(array('prefix' => 'contestants'), function()
	{
	    Route::get('{id}/edit', 'ContestantsController@getEdit');
	    Route::post('{id}/edit', 'ContestantsController@postEdit');
	    Route::get('{id}/delete', 'ContestantsController@getDelete');
	    Route::get('create', 'ContestantsController@getCreate');
	    Route::post('create', 'ContestantsController@postCreate');
	    Route::get('/', 'ContestantsController@getIndex');
	});

	// admin/judges
	Route::group(array('prefix' => 'judges'), function()
	{
	    Route::get('{id}/edit', 'JudgesController@getEdit');
	    Route::post('{id}/edit', 'JudgesController@postEdit');
	    Route::get('{id}/delete', 'JudgesController@getDelete');
	    Route::get('create', 'JudgesController@getCreate');
	    Route::post('create', 'JudgesController@postCreate');
	    Route::get('/', 'JudgesController@getIndex');
	});

	// admin/moderators
	Route::group(array('prefix' => 'moderators'), function()
	{
	    Route::get('{id}/edit', 'ModeratorsController@getEdit');
	    Route::post('{id}/edit', 'ModeratorsController@postEdit');
	    Route::get('{id}/delete', 'ModeratorsController@getDelete');
	    Route::get('create', 'ModeratorsController@getCreate');
	    Route::post('create', 'ModeratorsController@postCreate');
	    Route::get('/', 'ModeratorsController@getIndex');
	});

	// admin/events
	Route::group(array('prefix' => 'events'), function()
	{

		// admin/events/portions
		Route::group(array('prefix' => 'portions'), function()
		{
		    Route::post('create/api', 'PortionsController@postCreateApi');

		    Route::get('{id}/edit', 'PortionsController@getEdit');
		    Route::post('{id}/edit', 'PortionsController@postEdit');
		    Route::get('{id}/delete', 'PortionsController@getDelete');

		    Route::get('create', 'PortionsController@getCreate');
		    Route::post('create', 'PortionsController@postCreate');
		    Route::post('create', 'PortionsController@postCreate');
		    Route::get('/', 'PortionsController@getIndex');
		});

		// admin/events/{event_id}/portions/{portion_id}/criteria
		Route::group(array('prefix' => '{event_id}/criteria'), function()
		{
			//

			Route::get('{criterion_id}/edit', 'CriteriaController@getEdit');
		    Route::post('{criterion_id}/edit', 'CriteriaController@postEdit');
		    Route::get('{criterion_id}/delete', 'CriteriaController@getDelete');
		    Route::post('{criterion_id}/delete', 'CriteriaController@getDelete');
		    Route::get('create', 'CriteriaController@getCreate');
		    Route::post('create', 'CriteriaController@postCreate');
		    Route::get('{criterion_id}', 'CriteriaController@getShow');
		    Route::get('/', 'CriteriaController@getIndex');
		});

	    Route::get('{id}/edit', 'EventsController@getEdit');
	    Route::post('{id}/edit', 'EventsController@postEdit');
	    Route::get('{id}/delete', 'EventsController@getDelete');
	    Route::get('create', 'EventsController@getCreate');
	    Route::post('create', 'EventsController@postCreate');
	    Route::post('moderators', 'EventsController@postModerators');
	    Route::get('{id}', 'EventsController@getShow');
	    Route::get('/', 'EventsController@getIndex');
	});
});

// tests
Route::group(array('prefix' => 'test'), function()
{
	Route::get('/', function()
	{
		//
		$x = 1;
		echo 'x = '.$x ?: '';
	});

	Route::get('return-url', function(){
		//
		echo Request::path();
		var_dump(Input::all());
	});

	Route::get('schema-builder', function()
	{
		//

		echo 'Temporary Schema Builder.';
	});
});

Route::group(array('prefix' => 'moderator'), function()
{
    //

	Route::group(array('prefix' => 'events'), function()
	{
		//

		Route::group(array('prefix' => '{event_id}'), function()
		{
			// /moderator/events/{{event_id}}

			Route::group(array('prefix' => 'api'), function()
			{
				// /moderator/events/{{event_id}}/api
				Route::post('toggle-start', 'ModeratorController@postApiToggleStart');
				Route::post('toggle-pause', 'ModeratorController@postApiTogglePause');
				Route::post('resume', 'ModeratorController@postApiResume');
				Route::post('set-current-portion', 'ModeratorController@postApiSetCurrentPortion');
				Route::post('set-current-contestant', 'ModeratorController@postApiSetCurrentContestant');
			});

			Route::post('reset', 'ModeratorController@postResetEvent');

			Route::get('/', 'ModeratorController@getShow');
		});
	});

	Route::get('/', 'ModeratorController@getIndex');
});

// eg.: /judge
Route::group(array('prefix' => 'judge'), function()
{
	// eg.: /judge/events
	Route::group(array('prefix' => 'events'), function()
	{
		// eg.: /judge/events/7
		Route::group(array('prefix' => '{event_id}'), function()
		{
			Route::post('set-point', 'JudgeController@postSetPoint');
			Route::get('/', 'JudgeController@getShow');
		});

		Route::get('/', 'JudgeController@getIndex');
	});

    Route::get('/', 'JudgeController@getIndex');
});

