@extends('layouts.master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-sm-11"><h3>Errorcode</h3></div>
          <div class="col-sm-1">
            <a href="{{ route('createErrorcodeForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr class="table-primary">
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
                      <td align="center">{{ $e-></td>
                      <td align="center"><a href="{{ route('deleteErrorcode', $e->i_errorcode_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
@endsection    