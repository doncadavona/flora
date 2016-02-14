@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Judge</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{-- allow creation of new judge only if there is an event --}}

@if($events->count() > 0)

{{ Form::open(array('action' => array('JudgesController@postCreate', 'returnUrl='.Input::get('returnUrl') ))) }}

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
    <label for="name">User</label>
    <select class="form-control" name="user" autofocus>
      {{-- selector for roles --}}
      <option selected disabled hidden>-- Select --</option>
      @foreach($users as $user)
        <option value="{{ $user->id }}"
          @if($user->id == Input::Old('user'))
            selected
          @endif
          >{{ $user->username }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Create</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/judges' }}">Cancel</a>

{{ Form::close() }}

@else

<p class="alert alert-warning">
  Can't add judges without an event set.
  <a href="/admin/events/create" class="alert-link">Add event now.</a>
</p>

@endif

@stop