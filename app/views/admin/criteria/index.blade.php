@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Event Criteria</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $criteria->count() }} Criteria</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/criteriaVin/create"><i class="fa fa-user-plus fa-fw"></i> Add Criterion</a>
			</div>
		</div>
	</div>
	@if($criteria->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Event</th>
					<th>Portion</th>
					<th>Description</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			@foreach($criteria as $criterion)
				<tr>
					<td>{{$criterion->name}}</td>
					<td>{{$criterion->event->name}}</td>
					<td>{{$criterion->portion->name}}</td>
					<td>{{$criterion->description}}</td>
					<td>
						<a href="/admin/criteria/{{ $criterion->id }}/edit" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/criteria/{{ $criterion->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no criteria added yet.</p>
		</div>
	@endif
</div>

@stop