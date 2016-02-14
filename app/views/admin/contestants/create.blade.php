@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Contestant</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{-- allow creation of new contestants only if there is an event --}}

@if($events->count() > 0)

{{ Form::open(array('action' => array('ContestantsController@postCreate', 'returnUrl='.Input::get('returnUrl') ))) }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  @if(Input::get('returnUrl') == null)
    <div class="form-group">
      <label for="name">Event</label>
      <select class="form-control" name="event" autofocus>
        {{-- selector for roles --}}
        <option selected disabled hidden>-- Select --</option>
        @foreach($events as $event)
          <option value="{{ $event->id }}"
            @if($event->id == Input::Old('event'))
              selected
            @endif
            >{{ $event->name }}</option>
        @endforeach
      </select>
    </div>
  @else
    <div class="form-group">
      <label for="name">Event</label>
      <p class="form-control-static">{{$events->name}}</p>
      {{ Form::hidden('event', Input::get('event_id')) }}
    </div>
  @endif

  <div class="form-group">
    <label for="name">Municipality</label>
    <select class="form-control" name="municipality" autofocus>
      {{-- selector for roles --}}
      <option selected disabled hidden>-- Select --</option>
      @foreach($municipalities as $municipality)
        <option value="{{ $municipality->id }}"
          @if($municipality->id == Input::Old('municipality'))
            selected
          @endif
          >{{ $municipality->name }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <div class="form-group">
    <label for="name">First Name</label>
    {{ Form::text('first_name', Input::Old('first_name'), array('class' => 'form-control')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Middle Name</label>
    {{ Form::text('middle_name', Input::Old('middle_name'), array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    <label for="name">Last Name</label>
    {{ Form::text('last_name', Input::Old('last_name'), array('class' => 'form-control')) }}
  </div>

  <br>

  <div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
      <option selected disabled hidden>-- Select --</option>
      <option value="male"
        @if(Input::Old('gender')== 'male')
          selected
        @endif
      >Male</option>
      <option value="female"
        @if(Input::Old('gender') == 'female')
          selected
        @endif
      >Female</option>
    </select>
  </div>

  <div class="form-group">
    <label for="name">Birth Date</label>
    {{ Form::text('birth_date', Input::Old('birth_date'), array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
  </div>
  
  <br>

  <button type="submit" class="btn btn-primary">Create</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/contestants' }}">Cancel</a>

{{ Form::close() }}

@else

<p class="alert alert-warning">
  Can't add contestants without an event set.
  <a href="/admin/events/create" class="alert-link">Add event now.</a>
</p>

@endif

@stop