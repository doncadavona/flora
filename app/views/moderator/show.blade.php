@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{$event->name}} <small>Moderation</small></h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">General</span>
			</div>
			<div class="col-md-6 text-right">
				{{Form::open(array('url' => Request::path().'/reset'))}}
					<button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</button>
				{{Form::close()}}
			</div>
		</div>
	</div>
	<div class="panel-body">

		<div class="row" class="text-center">
			<div class="col-sm-4">
				<div class="text-center">
					<button id="btnStartEvent" class="btn btn-primary">Start Event</button>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="text-center">
					<button id="btnTogglePauseResumeEvent" class="btn btn-success">
						@if($event_state->event_status == 'STARTED')
							<i class="fa fa-pause"></i> Pause Event
						@elseif($event_state->event_status == 'PAUSED')
							<i class="fa fa-play"></i> Resume Event
						@else
							Pause/Resume
						@endif

					</button>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="text-center">
					<button id="btnEndEvent" class="btn btn-danger">End Event</button>
				</div>
			</div>
		</div>

		{{-- prepare security tokens --}}

		{{Form::open(array('url' => Request::path().'/api/start', 'method' => 'POST', 'id' => 'formStartEvent' ))}}
		{{Form::close()}}

		{{Form::open(array('url' => Request::path().'/api/end', 'method' => 'POST', 'id' => 'formEndEvent' ))}}
		{{Form::close()}}

		{{Form::open(array('url' => Request::path().'/api/toggle-pause', 'method' => 'POST', 'id' => 'formTogglePauseEvent' ))}}
		{{Form::close()}}

		{{Form::open(array('url' => Request::path().'/api/reset', 'method' => 'POST', 'id' => 'formResetEvent' ))}}
		{{Form::close()}}

	</div>
</div>


<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">Portions ({{ $portions->count() }})</span>
			</div>
			<div class="col-md-6 text-right">
				{{--  --}}
				<button class="btn btn-default btn-sm" id="btnSetCurrentPortion" disabled><i class="fa fa-play"></i> Set as Current</button>
			</div>
		</div>
	</div>
	@if($portions->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Points</th>
					<th>Description</th>
					<th>Criteria</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			{{Form::open(array('url' => Request::path().'/api/set-current-portion', 'id' => 'formPortions'))}}
			@foreach($portions as $portion)
				<tr
					@if($event_state->current_portion_id == $portion->id)
						class="success"
					@endif
				>
					<td><input type="radio" name="radioPortion" value="{{$portion->id}}"></td>
					<td>{{$portion->name}}</td>
					<td>{{$portion->points}}</td>
					<td>{{$portion->description}}</td>
					<td>{{$portion->criteria->count()}}</td>
					<td>
						@if($event_state->current_portion_id == $portion->id)
							<span class="label label-success">Current</span>
						@endif
					</td>
				</tr>
			@endforeach
			{{Form::close()}}
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no portions added yet.</p>
		</div>
	@endif
</div>

{{-- END of Portions --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">Contestants ({{ $contestants->count() }})</span>
			</div>
			<div class="col-md-6 text-right">
				{{--  --}}
				<button class="btn btn-default btn-sm" id="btnSetCurrentContestant" disabled><i class="fa fa-play"></i> Set as Current</button>
			</div>
		</div>
	</div>
	@if($contestants->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Municipality</th>
					<th>Name</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			{{Form::open(array('url' => Request::path().'/api/set-current-contestant', 'id' => 'formContestants'))}}
			@foreach($contestants as $contestant)
				<tr
					@if($event_state->current_contestant_id == $contestant->id)
						class="success"
					@endif
				>
					<td><input type="radio" name="radioContestant" value="{{$contestant->id}}"></td>
					<td>{{$contestant->municipality->name}}</td>
					<td>{{$contestant->person->last_name}} {{$contestant->person->first_name}} {{$contestant->person->middle_name}}</td>
					<td>
						@if($event_state->current_contestant_id == $contestant->id)
							<span class="label label-success">Current</span>
						@endif
					</td>
				</tr>
			@endforeach
			{{Form::close()}}
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no contestants added yet.</p>
		</div>
	@endif
</div>

{{-- END of Contestants --}}

@stop

@section('scripts')
@parent

<script>
$(function() {

	// initialize general controls button

	@if($event_state->event_status == 'UNSTARTED')
		$('#btnStartEvent').prop('disabled', false);
		$('#btnTogglePauseResumeEvent').prop('disabled', true);
		$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-default');
		$('#btnEndEvent').prop('disabled', true);
	@else
		$('#btnStartEvent').prop('disabled', true);
		$('#btnTogglePauseResumeEvent').prop('disabled', false);
		$('#btnEndEvent').prop('disabled', false);

		@if($event_state->event_status == 'STARTED')
			$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-warning');
		@elseif($event_state->event_status == 'PAUSED')
			$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-success');
		@endif		
	@endif
	@if($event_state->event_status == 'ENDED')
		$('#btnStartEvent').prop('disabled', true);
		$('#btnTogglePauseResumeEvent').prop('disabled', true);
		$('#btnEndEvent').prop('disabled', true);
	@endif

	$('#btnTogglePauseResumeEvent').click(function()
	{
		// alert('Toggle Pause Event Clicked');

		$.ajax({
			method: "POST",
			url: "/{{ Request::path() }}/api/toggle-pause",
			data: {
				_token: $('#formTogglePauseEvent').find('input[name=_token]').val(),
			}
		})
		.done(function( response ) {

			switch(response['msg']) {
				case 'SUCCESS':
					// alert('Item saved!');
					// comment the location.reload() to disable whole page refresh
					location.reload();
					if(response['event_status'] == 'STARTED')
					{
						$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-warning');
						$('#btnTogglePauseResumeEvent').html('<i class="fa fa-pause"></i> Pause Event');
					}
					if(response['event_status'] == 'PAUSED')
					{
						$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-success');
						$('#btnTogglePauseResumeEvent').html('<i class="fa fa-play"></i> Resume Event');
					}
					break;
				case 'FAILED':
					alert('Invalid input provided.' + response);
					break;
				default:
					alert('Default action. Status: ' + response);
					break;
			}
		})
		.fail(function(response) {
			alert('Connection Error. ' + response);
		})
		.always(function(response)
		{
			//
		});
	});

	$('#btnStartEvent').click(function()
	{
		// alert('End Event Clicked');

		$.ajax({
			method: "POST",
			url: "/{{ Request::path() }}/api/toggle-start",
			data: {
				_token: $('#formEndEvent').find('input[name=_token]').val(),
			}
		})
		.done(function( response ) {

			switch(response['msg']) {
				case 'SUCCESS':
					// alert('Item saved!');
					// location.reload();

					$('#btnStartEvent').prop('disabled', true);
					$('#btnTogglePauseResumeEvent').html('<i class="fa fa-pause"></i> Pause Event');
					$('#btnTogglePauseResumeEvent').attr('class', 'btn btn-warning');
					$('#btnTogglePauseResumeEvent').prop('disabled', false);
					$('#btnEndEvent').prop('disabled', false);

					$('#btnToggleStartEndEvent').attr('class', 'btn btn-danger');
					$('#btnToggleStartEndEvent').html('<i class="fa fa-stop"></i> End Event');
					$('#btnToggleStartEndEvent').show();

					break;
				case 'FAILED':
					alert('Invalid input provided.' + response);
					break;
				default:
					alert('Default action. Status: ' + response);
					break;
			}
		})
		.fail(function(response) {
			alert('Connection Error. ' + response);
		})
		.always(function(response)
		{
			//
		});
	});

	$('#btnEndEvent').click(function()
	{
		// alert('End Event Clicked');

		$.ajax({
			method: "POST",
			url: "/{{ Request::path() }}/api/toggle-start",
			data: {
				_token: $('#formEndEvent').find('input[name=_token]').val(),
			}
		})
		.done(function( response ) {

			switch(response['msg']) {
				case 'SUCCESS':
					// alert('Item saved!');
					// location.reload();
					if(response['event_status'] == 'ENDED')
					{
						$('#btnStartEvent').prop('disabled', true);
						$('#btnTogglePauseResumeEvent').prop('disabled', true);
						$('#btnEndEvent').prop('disabled', true);
					}
					break;
				case 'FAILED':
					alert('Invalid input provided.' + response);
					break;
				default:
					alert('Default action. Status: ' + response);
					break;
			}
		})
		.fail(function(response) {
			alert('Connection Error. ' + response);
		})
		.always(function(response)
		{
			//
		});
	});

	$('#btnSetCurrentPortion').click(function()
	{
		// alert($('input[name=radioPortion]:checked', '#formPortions').val());
		$('#formPortions').submit();
	});

	$('input[type="radio"][name="radioPortion"]').change(function()
	{
		// if ($(this).is(':checked'))
	 	// {
	 	//     alert($(this).val());
	 	// }

	 	$('#btnSetCurrentPortion').prop('disabled', false);

	});

	$('#btnSetCurrentContestant').click(function()
	{
		// alert($('input[name=radioPortion]:checked', '#formPortions').val());
		$('#formContestants').submit();
	});

	$('input[type="radio"][name="radioContestant"]').change(function()
	{
		// if ($(this).is(':checked'))
	 	// {
	 	//     alert($(this).val());
	 	// }

	 	$('#btnSetCurrentContestant').prop('disabled', false);

	});


});
</script>

@stop