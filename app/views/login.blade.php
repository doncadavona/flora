@extends('layouts.public')

@section('content')

<h1>Login</h1>
<hr>

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach
  <div class="form-group">
    <label for="email">Username</label>
    <input type="text" class="form-control" value="{{Input::Old('username')}}" id="username" name="username" placeholder="Enter username..." maxlength="16" autofocus>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password..." maxlength="16">
  </div>
  <div class="form-group">
    <!-- <div class="col-sm-offset-2 col-sm-10"> -->
      <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
{{ Form::close() }}

@stop