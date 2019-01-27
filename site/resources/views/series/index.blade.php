@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h3>Series</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createSeriesForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-dark">
                <th>Code</th>
                <th>Series</th>
                <th>Pallet Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seriesList as $s)
                <tr>
                  <td align="center">{{ $s->c_series_code }}</td>
                  <td>{{ $s->n_series_name }}</td>
                  <td align="center">{{ $s->i_pallet_qty }}</td>
                  <td align="center">
                  <a href="{{ route('editSeriesForm', $s->i_series_id) }}" class="btn btn-warning btn-sm">Edit</a>
                  <a href="{{ route('deleteSeries', $s->i_series_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection