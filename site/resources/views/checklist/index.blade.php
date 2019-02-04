@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h3>Check List</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createChecklistForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-dark">
                <th>#</th>
                <th>Series</th>
                <th>Create Date</th>
                <th>Effactive Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($forms as $value)
                <tr>
                  <td align="center">{{ $value->i_form_id }}</td>
                  <td align="center">{{ $value->getSeries->n_series_name }}</td>
                  <td align="center">{{ $value->d_form_created }}</td>
                  <td align="center">{{ $value->d_effective_date }}</td>
                  <td align="center">{{ $value->i_status == 1 ? 'Acitve' : 'Inactive' }}</td>
                  <td align="center">
                    @if($value->i_status == 0 && !$value->d_effective_date)
                      <a href="{{ route('editChecklistForm', $value->i_form_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection