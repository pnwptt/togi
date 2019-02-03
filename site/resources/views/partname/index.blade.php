@extends('layouts.master')

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
      <div class="col-sm-11"><h3>Part Name</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createPartNameForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-dark">
                <th>Part Name (Code)</th>
                <th>Series</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($partnameList as $pn)
                <tr>
                  <td align="center">{{ $pn->n_part_name }}</td>
                  <td align="center">{{ $pn->getSeries->n_series_name }}</td>
                  <td align="center">
                    <a href="{{ route('editPartNameForm', $pn->i_part_name_id) }}" class="btn btn-warning btn-sm">Edit</a>
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