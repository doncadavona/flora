@extends('layouts.public')

@section('content')

<h2>Edit Account</h2>

<hr>

{{
  Form::model($user,
    array(
      'action' => array('ProfileController@postEdit', $user->id)
      ,'role' => 'form'
    )
  )

}}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="role">Role</label>
      {{ Form::text('role', $user->role->name, array('class' => 'form-control', 'disabled')) }}
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    {{ Form::text('username', Input::Old('username'), array('class' => 'form-control', 'autofocus')); }}
  </div>

  <br>

  <div class="form-group">
    <label for="first_name">First Name</label>
    {{ Form::text('first_name', Input::Old('first_name'), array('class' => 'form-control')); }}
  </div>
  <div class="form-group">
    <label for="middle_name">Middle Name</label>
    {{ Form::text('middle_name', Input::Old('middle_name'), array('class' => 'form-control')); }}
  </div>
  <div class="form-group">
    <label for="last_name">Last Name</label>
    {{ Form::text('last_name', Input::Old('last_name'), array('class' => 'form-control')); }}
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="/profile/" class="btn btn-default">Cancel</a>

{{ Form::close() }}

@stop