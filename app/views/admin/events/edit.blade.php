@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Event</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{
  Form::model($event,
    array(
      'action' => array('EventsController@postEdit', $event->id, 'returnUrl='.Input::get('returnUrl'))
      ,'role' => 'form'
    )
  )
}}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', Input::Old('name'), array('class' => 'form-control', 'autofocus', 'placeholder' => 'ex. Binibining Pilipinas 2016')) }}
  </div>

  <div class="form-group">
    <label for="name">Date</label>
    {{ Form::text('date', Input::Old('date'), array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
  </div>
  
  <div class="form-group">
    <label for="description">Desciption</label>
    {{ Form::textarea('description', Input::Old('description'), array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'optional...')) }}
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Edit</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{$returnUrl or 'admin/events'}}">Cancel</a>

{{ Form::close() }}

@stop