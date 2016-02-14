@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New User</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="name">Role</label>
    <select class="form-control" name="role" autofocus>
      {{-- selector for roles --}}
      <option selected disabled>-- Select --</option>
      @foreach($roles as $role)
        <option value="{{ $role->id }}">{{ $role->name }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <div class="form-group">
    <label for="name">Username</label>
    <input type="text" class="form-control" id="username" name="username" value="{{Input::Old('username')}}" placeholder="Unique username...">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    {{ Form::password('password', array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    <label for="password_confirm">Confirm Password</label>
    {{ Form::password('password_confirm', array('class' => 'form-control')) }}
  </div>

  <br>

  <div class="form-group">
    <label for="name">First Name <span class="text-muted">(optional)</span></label>
    {{ Form::text('first_name', Input::Old('first_name'), array('class' => 'form-control')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Middle Name <span class="text-muted">(optional)</span></label>
    {{ Form::text('middle_name', Input::Old('middle_name'), array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    <label for="name">Last Name <span class="text-muted">(optional)</span></label>
    {{ Form::text('last_name', Input::Old('last_name'), array('class' => 'form-control')) }}
  </div>

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
    <label for="name">Birth Date <span class="text-muted">(optional)</span></label>
    {{ Form::text('birth_date', Input::Old('birth_date'), array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Create</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/users' }}">Cancel</a>

{{ Form::close() }}

@stop