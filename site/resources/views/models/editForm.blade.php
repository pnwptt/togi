@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Edit Models</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('editModels') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <input type="hidden" name="i_models_id" value="{{ $models->i_models_id }}">
          <div class="form-group">
            <label><b>Models</b></label>
            <input type="text" class="form-control" name="n_models_name" value="{{ trim($models->n_models_name) }}" required>
          </div>
          <div class="form-group">
            <label><b>Pallet Quantity</b></label>
            <input type="text" class="form-control" name="i_pallet_qty" value="{{ trim($models->i_pallet_qty) }}" required>
          </div>
          <div class="forn-group" align="center">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('models') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
