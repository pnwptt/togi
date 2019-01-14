@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h2>Create Series</h2></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createChecklist') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Series Code</label>
            <input type="text" class="form-control" name="c_series_code" required>
          </div>
          <div class="form-group">
            <label>Series Name</label>
            <input type="text" class="form-control" name="n_series_name" required>
          </div>
          <div class="form-group">
            <label>Pallet Quantity</label>
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
