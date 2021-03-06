@extends('layouts.master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
  <style type="text/css">
    table {
      border-radius: 0;
      padding: 0;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    @if(session()->has('error'))
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading">{{ session()->get('error') }}</h4>
            <p class="mb-0">
              {{ session()->get('message') }}
            </p>  
          </div>
        </div>
      </div>
    @endif
    <div class="row">
      <div class="col-sm-11"><h3>Errorcode</h3></div>
        <div class="col-sm-1">
          <a href="{{ route('createErrorcodeForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered" id="datatables">
              <thead>
                <tr class="table-light">
                  <th>Rank</th>
                  <th>Error code</th>
                  <th>Inspection detail</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($errorcodeList as $e)
                  <tr>
                    <td align="center">{{ $e->c_rank }}</td>
                    <td align="center">{{ $e->c_code }}</td>
                    <td>{{ $e->n_errorcode }}</td>
                    <td align="center">{{ $e->getType->n_errorcode_type }}</td>
                    <td align="center">
                      <a href="{{ route('editErrorcodeForm', $e->i_errorcode_id) }}" class="btn btn-warning btn-sm">Edit</a>
                      <!-- <a href="{{ route('deleteErrorcode', $e->i_errorcode_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a> -->
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

@section('js')
  <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
  <script type="text/javascript">
    $('#datatables').DataTable();
  </script>
@endsection
