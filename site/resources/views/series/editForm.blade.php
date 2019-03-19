@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Edit Sereis</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('editSeries') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <input type="hidden" name="i_series_id" value="{{ $series->i_series_id }}">
          <div class="form-group">
            <label><b>Models</b></label>
            <select class="form-control" name="i_models_id">
              <option value="" disabled selected>- Select Models -</option>
              @foreach( $modelList as $m )
              <option value="{{ $m->i_models_id }}" {{ $series->i_models_id == $m->i_models_id ? 'selected' : '' }} >
                {{ $m->n_models_name }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label><b>Series</b></label>
            <input type="text" class="form-control" name="n_series" value="{{ trim($series->n_series) }}" required>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('models') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection