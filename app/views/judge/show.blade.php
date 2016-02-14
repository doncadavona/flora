@extends('layouts.judge.layout')

@section('content')

<h2>Score Sheet</h2>
<hr>

{{-- put each event portion on its own panel --}}

@foreach($portions as $portion)

<?php
	// get and display portion's criteria
	$criteria = $portion->criteria;
?>

<div class="panel
	@if($event_state->current_portion_id == $portion->id)
		panel-success
	@else
		panel-default
	@endif
">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				{{$portion->name}} Portion
			</div>
			<div class="col-md-6 text-right">
				@if($event_state->current_portion_id == $portion->id)
					<span class="label label-success">Current</span>
				@endif
			</div>
		</div>
	</div>
	<div class="body">
		{{--  --}}
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Muncipality</th>
					<th>Contestant</th>
					@foreach($criteria as $criterion)
						<th>{{$criterion->name}} ({{$criterion->points}})</span></th>
					@endforeach
					<th></th>
				</tr>
			</thead>
			@foreach($contestants as $contestant)
				<tr
					@if($event_state->current_portion_id == $portion->id && $event_state->current_contestant_id == $contestant->id)
						class="warning"
					@endif
				>
					<td>{{$contestant->municipality->name}}</td>
					<td>{{$contestant->person->first_name}} {{$contestant->person->middle_name}} {{$contestant->person->last_name}}</td>
					@foreach($criteria as $criterion)
						<td>
							{{-- get and display criteria points --}}
							<?php
								$rating = Rating::where('event_id', $event->id)
									->where('portion_id', $portion->id)
									->where('criterion_id', $criterion->id)
									->where('contestant_id', $contestant->id)
									->first();
							?>
							@if($event_state->current_contestant_id == $contestant->id)
								
								{{-- show input form. First check if it's already scored --}}

								<?php
									$rating = Rating::where('event_id', $event->id)
							            ->where('portion_id', $portion->id)
							            ->where('criterion_id', $criterion->id)
							            ->where('contestant_id', $contestant->id)
							            ->first();
								?>
								
								@if(!$rating)
								{{Form::open(array('url' => '/judge/events/'.$event->id.'/set-point', 'class' => 'form-inline'))}}
									<input type="number" name="{{preg_replace('/\s+/', '', $criterion->name)}}" class="form-control input-points" min="0" max="{{$criterion->points}}" placeholder="00.0">
									{{Form::hidden('event', $event->id)}}
									{{Form::hidden('portion', $portion->id)}}
									{{Form::hidden('criterion', $criterion->id)}}
									{{Form::hidden('contestant', $contestant->id)}}
									<button class="btn btn-default">Set</button>
								{{Form::close()}}
								@else
									{{$rating->points}}
								@endif
							@else
								{{ $rating->points or '____'}}
							@endif
						</td>
					@endforeach
					<td class="text-right">
						@if($event_state->current_portion_id == $portion->id && $event_state->current_contestant_id == $contestant->id)
							<span class="label label-success">Current</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>
</div>

@endforeach

@stop

@section('scripts')
	@parent
	<script>
		setInterval(function () {update()}, 5000);
		
		function update()
		{
			$(function()
			{
				location.reload();
			});
		}
	</script>
@stop