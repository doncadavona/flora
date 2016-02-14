@extends('layouts.public')

@section('content')

<h2>Change Password</h2>

<hr>

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="new_password">New Password</label>
    <input autofocus type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password...">
  </div>
  <div class="form-group">
    <label for="new_password_confirm">Confirm New Password</label>
    <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Retype new  password...">
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Change</button>
  <a href="/profile" class="btn btn-default">Cancel</a>
{{ Form::close() }}

@stop