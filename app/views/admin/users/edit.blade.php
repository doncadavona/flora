@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit User</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{
  Form::model($user,
    array(
      'action' => array('UsersController@postEdit', $user->id)
      ,'role' => 'form'
    )
  )

}}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="role">Role</label>
    @if($user->id == 1)
      {{ Form::text('role', $user->role->name, array('class' => 'form-control', 'disabled')) }}
      {{ Form::hidden('role', $user->role->id, array('class' => 'form-control')) }}
    @else
      {{ Form::select('role', array(
            '1' => 'Admin',
            '2' => 'Moderator',
            '3' => 'Judge',
            '4' => 'Score Board'
            ),
            $user->role->id,
            array('class' => 'form-control', 'autofocus')
         )
      }}
    @endif
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    {{ Form::text('username', Input::Old('username'), array('class' => 'form-control', 'autofocus')); }}
  </div>

  <br>

  <div class="form-group">
    <label for="first_name">First Name</label>
    {{ Form::text('first_name', isset($user->person->first_name) ? $user->person->first_name : '', array('class' => 'form-control')); }}
  </div>
  <div class="form-group">
    <label for="middle_name">Middle Name</label>
    {{ Form::text('middle_name', isset($user->person->first_name) ? $user->person->first_name : '', array('class' => 'form-control')); }}
  </div>
  <div class="form-group">
    <label for="last_name">Last Name</label>
    {{ Form::text('last_name', isset($user->person->first_name) ? $user->person->first_name : '', array('class' => 'form-control')); }}
  </div>
  <div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
      <option selected disabled hidden>-- Select --</option>
      <option value="male"
        @if(isset($user->person->gender) && $user->person->gender == 'male')
          selected
        @endif
      >Male</option>
      <option value="female"
        @if(isset($user->person->gender) && $user->person->gender == 'female')
          selected
        @endif
      >Female</option>
    </select>
  </div>
  <div class="form-group">
    <label for="name">Birth Date</label>
    {{ Form::text('birth_date', isset($user->person->first_name) ? $user->person->first_name : '', array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
  </div>

  <br>

  <button type="submit" class="btn btn-primary">Okay, Submit</button>
  <a href="/admin/users/" class="btn btn-danger">Cancel</a>

{{ Form::close() }}

@stop