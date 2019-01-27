@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Create Errorcode Type</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createErrorcodetype')}}" method="post" class="form form-horizontal">
        {{ csrf_field() }}
        <div class="form-group">
          <label><b>Errorcode Type Name</b></label>
          <input type="text" class="form-control" name="n_errorcode_type" required>
        </div>
        <div class="form-group" align="center">
          <button type="submit" class="btn btn-success">Create</button>
          <a href="{{ route('errorcodetype') }}" class="btn btn-light">Cancel</a>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection