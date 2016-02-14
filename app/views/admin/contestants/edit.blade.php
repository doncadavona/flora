@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Contestant</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{
  Form::model($contestant,
    array(
      'action' => array('ContestantsController@postEdit', $contestant->id, 'returnUrl='.Input::get('returnUrl'))
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
          @if($event->id == $contestant->event_id)
            selected
          @endif
          >{{ $event->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="name">Municipality</label>
    <select class="form-control" name="municipality">
      @foreach($municipalities as $municipality)
        <option value="{{ $municipality->id }}"
          @if($municipality->id == $contestant->municipality->id))
            selected
          @endif
          >{{ $municipality->name }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <div class="form-group">
    <label for="name">First Name</label>
    {{ Form::text('first_name', $contestant->person->first_name ?: '', array('class' => 'form-control')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Middle Name</label>
    {{ Form::text('middle_name', $contestant->person->middle_name ?: '', array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    <label for="name">Last Name</label>
    {{ Form::text('last_name', $contestant->person->last_name ?: '', array('class' => 'form-control')) }}
  </div>

  <br>

  <div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
      <option selected disabled hidden>-- Select --</option>
      <option value="male"
        @if(isset($contestant->person->gender) && $contestant->person->gender == 'male')
          selected
        @endif
      >Male</option>
      <option value="female"
        @if(isset($contestant->person->gender) && $contestant->person->gender == 'female')
          selected
        @endif
      >Female</option>
    </select>
  </div>

  <div class="form-group">
    <label for="name">Birth Date</label>
    {{ Form::text('birth_date', $contestant->person->birth_date, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
  </div>  

  <br>

  <button type="submit" class="btn btn-primary">Okay, Submit</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/contestants' }}">Cancel</a>

{{ Form::close() }}

@stop