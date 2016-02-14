@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Portion</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{-- allow creation of new contestants only if there is an event --}}

@if($events->count() > 0)

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

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

  <br>

  <div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', Input::Old('name'), array('class' => 'form-control', 'placeholder' => 'ex. Talent Portion...')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Description</label>
    {{ Form::textarea('description', Input::Old('description'), array('class' => 'form-control', 'rows' => 3)) }}
  </div>
  
  <br>

  <button type="submit" class="btn btn-primary">Create</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/events/portions' }}">Cancel</a>

{{ Form::close() }}

@else

<p class="alert alert-warning">
  Can't add event portion without an event set.
  <a href="/admin/events/portions/create" class="alert-link">Add portion now.</a>
</p>

@endif

@stop