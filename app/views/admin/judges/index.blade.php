@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Judges</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $judges->count() }} Judges</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/judges/create"><i class="fa fa-user-plus fa-fw"></i> Add Judge</a>
			</div>
		</div>
	</div>
	@if($judges->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Username</th>
					<th>Name</th>
					<th>Birth Date</th>
					<th>Gender</th>
					<th>{{-- actions --}}</th>
				</tr>
			</thead>
			@foreach($judges as $judge)
				<tr>
					<td>{{$judge->user->username}}</td>
					<td>{{$judge->user->first_name}} {{$judge->user->middle_name}} {{$judge->user->last_name}}</td>
					<td>
						@if($judge->user->birth_date != null)
							{{ date_format(date_create($judge->user->birth_date), 'd M Y') }}
							({{ date_diff(date_create($judge->user->birth_date), date_create('today'))->y }} years)
						@endif
					</td>
					<td>{{$judge->user->gender}}</td>
					<td>
						{{-- actions --}}
						
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no judges added yet.</p>
		</div>
	@endif
</div>

@stop