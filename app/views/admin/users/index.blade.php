@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Users</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $users->count() }} Users</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default" href="/admin/users/create"><i class="fa fa-user-plus fa-fw"></i> New User</a>
			</div>
		</div>
	</div>
	<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Role</th>
				<th>Username</th>
				<th>Name</th>
				<th>Date Registered</th>
				<th>Last Update</th>
				<th><!-- actions --></th>
			</tr>
		</thead>
		@foreach($users as $user)
			<tr>
				<td>{{$user->role->name}}</td>
				<td>{{$user->username}}</td>
				<td>
					@if($user->person != null)
						{{$user->person->first_name}} {{$user->person->middle_name}} {{$user->person->last_name}}
					@endif
				</td>
				<td>{{$user->created_at}}</td>
				<td>{{$user->updated_at}}</td>
				<td>

					<a href="/admin/users/{{ $user->id }}/edit" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					@if($user->role_id != 1 || $user->id != 1)
						{{--@if($user->verified == 0)
							| <a href="/admin/users/{{ $user->id }}/toggle-approval" class="text-success">Approve <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
						@else
							<a href="/admin/users/{{ $user->id }}/toggle-approval" class="text-success">Disapprove <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
						@endif--}}
						<a href="/admin/users/{{ $user->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					@endif
				</td>
			</tr>
		@endforeach
	</table>
	</div>
</div>


@stop