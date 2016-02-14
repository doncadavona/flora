@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Events</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $events->count() }} Events</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/events/create"><i class="fa fa-plus fa-fw"></i> New Event</a>
			</div>
		</div>
	</div>
	@if($events->count() > 0)
	<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th>Description</th>
				<th>Portions</th>
				<th>Contestants</th>
				<th>{{-- actions --}}</th>
			</tr>
		</thead>
		@foreach($events as $event)
			<tr>
				<td><a href="/admin/events/{{$event->id}}">{{$event->name}}</a></td>
				<td>
					@if($event->date != null)
						{{ date_format(date_create($event->date), 'd M Y') }}
					@endif
				</td>
				<td>{{$event->description}}</td>
				<td>
					<a href="/admin/events/{{$event->id}}/#portions">{{$event->portions->count()}}</a>
				</td>
				<td>
					<a href="/admin/events/{{$event->id}}/#contestants">{{$event->contestants->count()}}</a>
				</td>
				<td>
					<a href="/admin/events/{{ $event->id }}/edit" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a href="/admin/events/{{ $event->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</td>
			</tr>
		@endforeach
	</table>
	</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no events added yet. <a href="/admin/events/create">Add event now.</a></p>
		</div>
	@endif
</div>


@stop