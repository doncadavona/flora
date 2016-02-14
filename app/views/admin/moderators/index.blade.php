@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Moderators</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $moderators->count() }} Moderators</span>
			</div>
			<div class="col-md-6 text-right">
				{{--  --}}
			</div>
		</div>
	</div>
	@if($moderators->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Username</th>
				</tr>
			</thead>
			@foreach($moderators as $moderator)
				<tr>
					<td>{{$moderator->username}}<td>
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