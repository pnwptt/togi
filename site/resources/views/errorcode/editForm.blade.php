@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h4>Edit Errorcode</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="{{ route('editErrorcode')}}" method="post" class="form form-horizontal">
          {{ csrf_field() }}
          <input type="hidden" name="i_errorcode_id" value="{{ $errorcode->i_errorcode_id }}">
          <div class="form-group">
            <label><b>Type</b></label>
            <select name="i_errorcode_type_id" class="form-control">
              <option value="" selected disabled>- Select Type -</option>
              @foreach($types as $t)
                <option value="{{ $t->i_errorcode_type_id }}" {{ $errorcode->i_errorcode_type_id === $t->i_errorcode_type_id ? 'selected' : '' }}>
                  {{ $t->n_errorcode_type }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label><b>Code</b></label>
            <input type="text" class="form-control" name="c_code" value="{{ trim($errorcode->c_code) }}" required>
          </div>
          <div class="form-group">
            <label><b>Errorcode Name</b></label>
            <input type="text" class="form-control" name="n_errorcode" value="{{ trim($errorcode->n_errorcode) }}" required>
          </div>
          <div class="form-group">
            <label><b>Rank</b></label>
              <select name="c_rank" class="form-control">
                <option value=" ">- Select Rank -</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
              </select>
          </div>
          <div class="form-group" align="center">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('errorcode') }}" class="btn btn-light">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection