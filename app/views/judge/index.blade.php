@extends('layouts.judge.layout')

@section('content')

<h2>{{$event->name}}</h2>
<hr>


<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">General Info</span>
			</div>
			<div class="col-md-6 text-right">
				{{--  --}}
			</div>
		</div>
	</div>
	@if(isset($event))
	<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th>Description</th>
				<th>Portions</th>
				<th>Contestants</th>
			</tr>
		</thead>
		<tr>
			<td><a href="/judge/events/{{$event->id}}">{{$event->name}}</a></td>
			<td>
				@if($event->date != null)
					{{ date_format(date_create($event->date), 'd M Y') }}
				@endif
			</td>
			<td>{{$event->description}}</td>
			<td>
				{{$event->portions->count()}}
			</td>
			<td>
				{{$event->contestants->count()}}
			</td>
		</tr>
	</table>
	</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">Your account is not yet assigned to judge any eent yet. <a href="/admin/events/create">Add event now.</a></p>
		</div>
	@endif
</div>

@stop