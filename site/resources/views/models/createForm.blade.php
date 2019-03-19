@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Create Models</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createModels') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label><b>Models Name</b></label>
            <input type="text" class="form-control" name="n_models_name" placeholder="Enter Models Name" required>
          </div>
          <div class="form-group">
            <label><b>Pallet Quantity</b></label>
            <input type="number" class="form-control" name="i_pallet_qty" placeholder="Enter Pallet Quantity" required>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('models') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection