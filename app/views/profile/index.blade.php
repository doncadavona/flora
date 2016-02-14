@extends('layouts.public')

@section('content')

<h2>Account</h2>
<hr>

<form class="form-horizontal">
	<div class="form-group">
    <label class="col-sm-2 control-label">Role</label>
    <div class="col-sm-10">
      <p class="form-control-static">{{ $user->role->name }}</p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
      <p class="form-control-static">{{ $user->username }}</p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Account Status</label>
    <div class="col-sm-10">
      <p class="form-control-static">
      	@if($user->verified == 1)
      		<span class="text-success">Approved</span>
      	@else
      		<span class="text-warning">Pending for Approval</span>
      	@endif
      </p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a href="/profile/edit" class="btn btn-default">Edit</a>
      <a href="/profile/change-password" class="btn btn-default">Change Password</a>
      @if($user->id != 1)
        <a href="/profile/delete" class="btn btn-danger">Delete Account</a>
      @endif
    </div>
  </div>
</form>

@stop