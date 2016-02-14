@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Contestants</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $contestants->count() }} Contestants</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/contestants/create"><i class="fa fa-user-plus fa-fw"></i> Add Contestant</a>
			</div>
		</div>
	</div>
	@if($contestants->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Birth Date</th>
					<th>Gender</th>
					<th>Municipality</th>
					<th>Event</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			@foreach($contestants as $contestant)
				<tr>
					<td>{{$contestant->person->first_name}} {{$contestant->person->middle_name}} {{$contestant->person->last_name}}</td>
					<td>
						@if($contestant->person->birth_date != null)
							{{ date_format(date_create($contestant->person->birth_date), 'd M Y') }}
							({{ date_diff(date_create($contestant->person->birth_date), date_create('today'))->y }} years)
						@endif
					</td>
					<td>{{$contestant->person->gender}}</td>
					<td>{{$contestant->municipality->name}}</td>
					<td>{{$contestant->event->name}}</td>
					<td>
						<a href="/admin/contestants/{{ $contestant->id }}/edit" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/contestants/{{ $contestant->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no contestants added yet.</p>
		</div>
	@endif
</div>

@stop