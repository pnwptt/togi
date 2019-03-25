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
      <div class="col-sm-8"><h3>Models / Series</h3></div>
      <div class="col-sm-2">
        <a href="{{ route('createModelsForm') }}" class="btn btn-info btn-ms btn-block">Add Model</a>
      </div>
      <div class="col-sm-2">
        <a href="{{ route('createSeriesForm') }}" class="btn btn-success btn-ms btn-block">Add Series</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-light">
                <th>Models</th>
                <th>Series</th>
                <th>Pallet Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($modelList as $m)
                <tr>
                  <td align="center">{{ $m->n_models_name }}</td>
                  <td align="center">
                    <ul align="left">
                      @foreach($m->getSeriesList as $p)
                        <li><a href="{{ route('editSeriesForm', $p->i_series_id) }}">{{ $p->n_series }}</a></li>
                      @endforeach
                    </ul>
                  </td>
                  <td align="center">{{ $m->i_pallet_qty }}</td>
                  <td align="center">
                  <a href="{{ route('editModelsForm', $m->i_models_id) }}" class="btn btn-warning btn-sm">Edit</a>
                  <!-- <a href="{{ route('deleteModels', $m->i_models_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td> -->
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection