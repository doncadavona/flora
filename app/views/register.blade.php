@extends('layouts.public')

@section('content')

<h1>Register</h1>

<hr>

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{Input::Old('name')}}" placeholder="Name...">
  </div>

  <br>

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" value="{{Input::Old('email')}}" id="email" name="email" placeholder="Enter email...">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
  </div>
  <div class="form-group">
    <label for="password_confirm">Confirm Password</label>
    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Retype password...">
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Register</button>
  <button type="clear" class="btn btn-default">Clear</button>
{{ Form::close() }}

@stop