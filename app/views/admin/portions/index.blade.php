@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Event Portions</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $portions->count() }} Portions</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/events/portions/create"><i class="fa fa-user-plus fa-fw"></i> Add Portion</a>
			</div>
		</div>
	</div>
	@if($portions->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Event</th>
					<th>Points</th>
					<th>Description</th>
					<th>Criteria</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			@foreach($portions as $portion)
				<tr>
					<td>{{$portion->name}}</td>
					<td><a href="/admin/events/{{$portion->event->id}}">{{$portion->event->name}}</a></td>
					<td>{{$portion->points}}</td>
					<td>{{$portion->description}}</td>
					<td>{{$portion->criteria->count()}}</td>
					<td>
						<a href="/admin/events/portions/{{ $portion->id }}/edit" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/events/portions/{{ $portion->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no portions added yet.</p>
		</div>
	@endif
</div>

@stop