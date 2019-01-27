@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Edit Series</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('editSeries') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <input type="hidden" name="i_series_id" value="{{ $series->i_series_id }}">
          <div class="form-group">
            <label><b>Code</b></label>
            <input type="text" class="form-control" name="c_series_code" value="{{ trim($series->c_series_code) }}" required>
          </div>
          <div class="form-group">
            <label><b>Series</b></label>
            <input type="text" class="form-control" name="n_series_name" value="{{ trim($series->n_series_name) }}" required>
          </div>
          <div class="form-group">
            <label><b>Pallet Quantity</b></label>
            <input type="text" class="form-control" name="i_pallet_qty" value="{{ trim($series->i_pallet_qty) }}" required>
          </div>
          <div class="forn-group" align="center">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('series') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
