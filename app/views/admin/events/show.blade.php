@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
        	{{$event->name}}
			<small>Event</small>
        </h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">Event Information</span>	
			</div>
			<div class="col-md-6 text-right">
				<a href="/admin/events/{{$event->id}}/edit?returnUrl={{Request::path()}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit Info</a>
				<a href="/admin/events/create?returnUrl={{Input::path()}}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> New Event</a>
				<a href="/admin/events" class="btn btn-default btn-sm"><i class="fa fa-list"></i> Events List</a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$event->name}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$event->description}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Date</label>
				<div class="col-sm-10">
					<p class="form-control-static">
						@if($event->date != null)
							{{ date_format(date_create($event->date), 'd M Y') }}
						@endif
					</p>
				</div>
			</div>
			<br>
			{{-- <div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Created At</label>
				<div class="col-sm-10">
					<p class="form-control-static">
						{{$event->created_at}}
					</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Last Update</label>
				<div class="col-sm-10">
					<p class="form-control-static">
						{{$event->updated_at}}
					</p>
				</div>
			</div>
 --}}		</form>
	</div>
</div>

<div class="panel panel-default" id="portions">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{$event->portions->count()}} Portions</span>
			</div>
			<div class="col-md-6 text-right">
				<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#createPortionModal">
  					<i class="fa fa-plus"></i> Add Portion
				</button>
			</div>
		</div>
	</div>
	@if($event->portions->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Points</th>
					<th>Description</th>
					<th>Criteria</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			@foreach($portions as $portion)
				<tr>
					<td>{{$portion->name}}</td>
					<td>{{$portion->points}}</td>
					<td>{{$portion->description}}</td>
					<td>{{$portion->criteria->count()}}</td>
					<td>
						<a href="/admin/events/portions/{{ $portion->id }}/edit?returnUrl={{Request::path()}}" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/events/portions/{{ $portion->id }}/delete?returnUrl={{Request::path()}}" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no portions set on this event yet.
				<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#createPortionModal">
  					<i class="fa fa-plus"></i> Click to Add Portion
				</button>
			</p>
		</div>
	@endif
</div>


<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $criteria->count() }} Criteria</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default btn-sm" href="/admin/events/{{$event->id}}/criteria/create?returnUrl={{Request::path()}}"><i class="fa fa-plus fa-fw"></i> Add Criterion</a>
			</div>
		</div>
	</div>
	@if($criteria->count() > 0)
		<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Portion</th>
					<th>Points</th>
					<th>Description</th>
					<th><!-- actions --></th>
				</tr>
			</thead>
			@foreach($criteria as $criterion)
				<tr>
					<td>{{$criterion->name}}</td>
					<td>{{$criterion->portion->name}}</td>
					<td>{{$criterion->points}}</td>
					<td>{{$criterion->description}}</td>
					<td>
						<a href="/admin/events/{{$event->id}}/criteria/{{ $criterion->id }}/edit?returnUrl={{Request::path()}}" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/events/{{$event->id}}/criteria/{{ $criterion->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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


<div class="panel panel-default" id="contestants">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<span class="text-muted">{{ $contestants->count() }} Contestants</span>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-default btn-sm" href="/admin/contestants/create?event_id={{$event->id}}&returnUrl={{Request::path()}}"><i class="fa fa-plus fa-fw"></i> Add Contestant</a>
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
					<td>
						<a href="/admin/contestants/{{ $contestant->id }}/edit?returnUrl={{Request::path()}}" class="text-info">Edit <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
						<a href="/admin/contestants/{{ $contestant->id }}/delete" class="text-danger">Delete <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</table>
		</div>
	@else
		<div class="panel-body">
			<p class="alert alert-warning">There are no contestants added to {{$event->name}} yet.</p>
		</div>
	@endif
</div>

@stop

@section('modals')

{{-- modal markups --}}


{{-- Modal --}}
<div class="modal fade" id="createPortionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Portion to {{$event->name}}</h4>
      </div>
      <div class="modal-body">
      	
		{{-- body --}}

		{{ Form::open(array('id' => 'createPortionForm')) }}

		  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
		    {{ $error }}
		  @endforeach

		  <div class="form-group">
		    <label for="name">Name</label>
		    {{ Form::text('name', Input::Old('name'), array('id' => 'portionName', 'class' => 'form-control', 'placeholder' => 'ex. Talent Portion...')) }}
		  </div>

		  <div class="form-group">
		    <label for="name">Points</label>
		    {{ Form::number('points', Input::Old('points'), array('id' => 'portionPoints', 'class' => 'form-control', 'placeholder' => 'Points...', 'min' => 0, 'max' => 100)) }}
		  </div>
		  
		  <div class="form-group">
		    <label for="name">Description</label>
		    {{ Form::textarea('description', Input::Old('description'), array('class' => 'form-control', 'rows' => 3)) }}
		  </div>
		  
		  <br>

		{{ Form::close() }}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btnCreatePortionForm" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btnCreatePortionForm" id="btnSavePortion">Save</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
	@parent
	<script>
	$(function() {
		$('#createPortionModal').on('shown.bs.modal', function(){
  			$('#portionName').focus();
		});

		$('#btnSavePortion').click(function()
		{
			// disable buttons

			$('.btnCreatePortionForm').attr('disabled', true);
			$('#btnSavePortion').html('<i class="fa fa-spinner fa-pulse"></i> Saving...');

			// alert('Ajax starting...');
			$.ajax({
				method: "POST",
				url: "/admin/events/portions/create/api",
				data: {
					_token: 		$('#createPortionForm').find('input[name=_token]').val(),
					event_id: 		{{$event->id}},
					name: 			$('#createPortionForm').find('input[name=name]').val(),
					points: 		$('#createPortionForm').find('input[name=points]').val(),
					description: 	$('#createPortionForm').find('textarea[name=description]').val()
				}

			})
			.done(function( response ) {

				// alert(JSON.stringify(response));
				// alert(JSON.stringify(JSON.parse(response)));
				// alert( "Server response: " + response['message'] );

				switch(response[0].status) {
					case 'SUCCESS':
						$('.btnCreatePortionForm').html('Saved...');
						$('#btnSavePortion').attr('class', 'btn btn-success');
						alert('Item saved!');
						location.reload();
						break;
					case 'INVALID_INPUT':
						alert('Invalid input provided.');
						break;
					case 'SERVER_ERROR':
						alert('Server error. Please retry later.');
						break;
					default:
						alert('Default action. Status: ' + response['status']);
						break;
				}
			})
			.fail(function(response) {
				alert('failed' + response);
			})
			.always(function(response)
			{
				$('.btnCreatePortionForm').attr('disabled', false);
				$('#btnSavePortion').html('Save');
			});
		});
	});
	</script>
@stop