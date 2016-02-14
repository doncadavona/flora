@extends('layouts.sb-admin-2')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Criterion in {{$event->name}}</h1>
    </div>
    {{-- /.col-lg-12 --}}
</div>
{{-- /.row --}}

{{-- allow creation of new contestants only if there is an event --}}

@if(isset($portion))

{{ Form::open() }}

  @foreach($errors->all('<p class="text-danger">:message</p>') as $error)
    {{ $error }}
  @endforeach

  <div class="form-group">
    <label for="name">Portion</label>
    <p class="form-control-static">{{$portion->name}}</p>
    {{FOrm::hidden('portion', $portion->id)}}
  </div>

  <div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', $criterion->name, array('class' => 'form-control', 'autofocus')) }}
  </div>
  
  <div class="form-group">
    <label for="name">Points</label>
    {{ Form::number('points', $criterion->points, array('class' => 'form-control', 'min' => 0, 'max' => 100)) }}
  </div>
  <div class="form-group">
    <label for="name">Description</label>
    {{ Form::textarea('description', $criterion->description, array('class' => 'form-control', 'rows' => 3)) }}
  </div>
  
  <br>

  <button type="submit" class="btn btn-primary">Edit</button>
  <button type="reset" class="btn btn-default">Clear</button>
  <?php $returnUrl = Input::get('returnUrl') ?>
  <a class="btn btn-danger" href="/{{ $returnUrl or 'admin/contestants' }}">Cancel</a>

{{ Form::close() }}

@else
    <p class="alert alert-warning">
      Opps! Where's that portion?
    </p>
@endif

@stop