@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Edit Part Name</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col md-4">
        <form action="{{ route('editPartName') }}" method="post" class="form form-horizontal"></form>
          {{ csrf_field() }}
          <input type="hidden" name="i_part_name_id" value="{{ $partName->i_part_name_id }}">
          <div class="form-group">
            <label><b>Series</b></label>
            <select class="form-control" name="i_series_id" >
              <option value="" disabled selected>- Select Series -</option>
              @foreach( $seriesList as $s )
                <option value="{{ $s->i_series_id }}">{{ $s->n_series_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label><b>Part Name</b></label>
            <input type="text" class="form-control" name="n_part_name" value="{{ trim($partName->n_part_name) }}" required>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('partName') }}" class="btn btn-light">Cancel</a>
          </div>
      </div>
    </div>
  </div>
@endsection