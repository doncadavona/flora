@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Portion</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{
  Form::model($portion,
    array(
      'action' => array('PortionsController@postEdit', $portion->id, 'returnUrl='.Input::get('returnUrl'))
      ,'role' => 'form'
    )
  )

}}

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
          @if($event->id == $portion->event->id)
            selected
          @endif
          >{{ $event->name }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', $portion->name, array('class' => 'form-control')) }}
  </div>

  <div class="form-group">
    <label for="name">Points</label>
    {{ Form::number('points', Input::Old('points'), array('id' => 'portionPoints', 'class' => 'form-control', 'placeholder' => 'Points...', 'min' => 0, 'max' => 100)) }}
  </div>

  <div class="form-group">
    <label for="name">Description</label>
    {{ Form::textarea('description', $portion->description, array('class' => 'form-control', 'rows' => 3)) }}
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Edit</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/events/portions' }}">Cancel</a>


{{ Form::close() }}

@stop