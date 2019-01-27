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
                <th>Create Date</th>
                <th>Effactive Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($forms as $value)
                <tr>
                  <td align="center">{{ $value->i_forms_id }}</td>
                  <td align="center">{{ $value->d_forms_create }}</td>
                  <td align="center">{{ $value->d_effactive_date }}</td>
                  <td align="center">{{ $value->i_status == 1 ? 'Acitve' : 'Inactive' }}</td>
                  <td align="center">
                    <a href="{{ route('editRecordForm', $value->i_forms_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('deleteSeries', $value->i_forms_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
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