@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h2>Series</h2></div>
      <div class="col-sm-1">
        <a href="{{ route('createChecklistForm') }}" class="btn btn-success btn-lg btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-info">
                <th>Code</th>
                <th>Series</th>
                <th>Pallet Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seriesList as $value)
                <tr>
                  <td align="center">{{ $value->c_series_code }}</td>
                  <td>{{ $value->n_series_name }}</td>
                  <td align="center">{{ $value->i_pallet_qty }}</td>
                  <td align="center"><a href="{{ route('deleteSeries', $value->i_series_id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection