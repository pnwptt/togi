@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Create Part Name</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('createPartName') }}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label><b>Series</b></label>
            <select class="form-control" name="i_series_id">
              <option value="" disabled selected>- Select Series -</option>
              @foreach( $seriesList as $s )
                <option value="{{ $s->i_series_id }}">{{ $s->n_series_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label><b>Part Name</b></label>
            <input type="text" class="form-control" name="n_part_name" placeholder="Enter Part Name" required>
          </div>
          <div class="form-group">
            <label><b></b></label>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('partName') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection