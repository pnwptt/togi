@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h4>Series</h4></div>
      <div class="col-sm-1">
        <a href="{{ route('createSeriesForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-secondary">
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
                  <td align="center"><a href="{{ route('deleteSeries', $value->i_series_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection