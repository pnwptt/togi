@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Create Series</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createSeries') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label><b>Series Code</b></label>
            <input type="text" class="form-control" name="c_series_code" required>
          </div>
          <div class="form-group">
            <label><b>Series Name</b></label>
            <input type="text" class="form-control" name="n_series_name" required>
          </div>
          <div class="form-group">
            <label><b>Pallet Quantity</b></label>
            <input type="number" class="form-control" name="i_pallet_qty" required>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('series') }}" class="btn btn-default">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection