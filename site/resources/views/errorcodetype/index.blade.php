@extends('layouts.master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-sm-11"><h4>Errorcode Type</h4></div>
        <div class="col-sm-1">
          <a href="{{ route('createErrorcodetypeForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="table-secondary">
                  <th>Errorcode Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($errorcodetypeList as $et)
                  <tr>
                    <td align="center">{{ $et->n_errorcode_type }}</td>
                    <td align="center"><a href="{{ route('deleteErrorcodetype', $et->i_errorcode_type_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection