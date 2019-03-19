@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Create Series</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createSeries') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label><b>Models</b></label>
            <select class="form-control" name="i_models_id">
              <option value="" disabled selected>- Select Models -</option>
              @foreach( $modelList as $m )
                <option value="{{ $m->i_models_id }}">{{ $m->n_models_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label><b>Series</b></label>
            <input type="text" class="form-control" name="n_series" placeholder="Enter Series" required>
          </div>
          <div class="form-group">
            <label><b></b></label>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('models') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection