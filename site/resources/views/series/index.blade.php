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
                <th>Sereis</th>
                <th>Model</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seriesList as $s)
                <tr>
                  <td align="center">{{ $s->n_series }}</td>
                  <td align="center">{{ $s->getModels->n_models_name }}</td>
                  <td align="center">
                    <a href="{{ route('editSeriesForm', $s->i_series_id) }}" class="btn btn-warning btn-sm">Edit</a>
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