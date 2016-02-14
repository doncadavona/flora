@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Criterion to {{$event->name}}</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{-- allow creation of new contestants only if there is an event --}}

@if($portions->count() > 0)

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="name">Portion</label>
    <select class="form-control" name="portion" autofocus>
      {{-- selector for roles --}}
      <option selected disabled hidden>-- Select --</option>
      @foreach($portions as $portion)
        <option value="{{ $portion->id }}"
          @if($portion->id == Input::Old('portion'))
            selected
          @endif
          >{{ $portion->name }}</option>
      @endforeach
    </select>
  </div>

  <br>

  <div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', Input::Old('name'), array('class' => 'form-control')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Points</label>
    {{ Form::number('points', Input::Old('points'), array('class' => 'form-control', 'min' => 0, 'max' => 100)) }}
  </div>
  <div class="form-group">
    <label for="name">Description</label>
    {{ Form::textarea('description', Input::Old('description'), array('class' => 'form-control', 'rows' => 3)) }}
  </div>
  
  <br>

  <button type="submit" class="btn btn-primary">Create</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/contestants' }}">Cancel</a>

{{ Form::close() }}

@else
    <p class="alert alert-warning">
      Can't add criteria without a portion.
    </p>
@endif

@stop