@extends('layouts.master')

@section('content')
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-4"><h4>Create Series</h4></div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <form action="{{ route('createChecklist') }}" method="post" class="form form-horizontal">
            {{ csrf_field() }}
            <div class="form-group" align="center">
              <label><b>Series</b>
              <select name="i_series_id" class="form-control">
                <option value="">- Select Series -</option>
                @foreach($seriesList as $s)
                  <option value="{{ $s->i_series_id }}">{{ $s->n_series_name }} [ {{ $s->c_series_code }} ]</option>
                @endforeach
              </select></label>
            </div>
            <div class="form-group">
              <label><b>Measurement Errorcode :</b></label>
              <input type="text" class="form-control" placeholder="Enter Measurement Errorcode" list="measurementErrorcode"
                @keydown.enter.prevent="addErrorcode(1)" id="currentMeasurementErrorcode">
            </div>
            <div class="form-group" align="center">
              <label><b>Maximum Value</b>
                <input type="number" class="form-control" name="" placeholder="Enter Max Value">
              </label>
              <label><b>Minimum Value</b>
                <input type="number" class="form-control" name="" placeholder="Enter Min Value">
              </label>
            </div>
            <div class="form-group">
              <label><b>Test Specification Errorcode :</b></label>
              <input type="text" class="form-control" placeholder="Enter Test Specification Errorcode" list="testSpecificationErrorcode"
                @keydown.enter.prevent="addErrorcode(2)" id="currentTestSpecificationErrorcode">
            </div>
            <div class="form-group" align="center">
              <label><b>Maximum Value</b>
                <input type="number" class="form-control" name="" placeholder="Enter Max Value">
              </label>
              <label><b>Minimum Value</b>
                <input type="number" class="form-control" name="" placeholder="Enter Min Value">
              </label>
            </div>
            <div class="form-group" align="center">
              <button type="submit" class="btn btn-success">Add</button>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                  <thead>
                    <tr class="table-dark">
                      <th>Measurement Errorcode</th>
                      <th>Maximum Value</th>
                      <th>Minimum Value</th>
                      <th>Test Specification Errorcode</th>
                      <th>Maximum Value</th>
                      <th>Minimum Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td align="center"></td>
                      <td align="center"></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="form-group" align="center">
              <button type="submit" class="btn btn-success">Create</button>
              <a href="{{ route('checklist') }}" class="btn btn-light">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <datalist id="measurementErrorcode">
      @foreach($measurementErrorcode as $value)
        <option value="{{ $value->c_code }}">{{ $value->n_errorcode }}</option>
      @endforeach
    </datalist>
    <datalist id="testSpecificationErrorcode">
      @foreach($testSpecificationErrorcode as $value)
        <option value="{{ $value->c_code }}">{{ $value->n_errorcode }}</option>
      @endforeach
    </datalist>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        errorcodeList: [],
        measurementErrorcode: [],
        testSpecificationErrorcode: [],
        currentMeasurementErrorcode: '',
        currentTestSpecificationErrorcode: ''
      },
      // mounted() {
      //   console.log('mounted')
      },
      methods: {
        addErrorcode(type) {
          var errorcode = '';
          switch (type) {
            case 1 : 
              errorcode = this.currentMeasurementErrorcode;
              break;

            case 2 :
              errorcode = this.currentTestSpecificationErrorcode;
              break;

            default:
              break;
          }
          if (errorcode) {
            axios.get('{{ route("checkerrorcode") }}', {
              params: {
                type: type,
                code: errorcode
              }
            })
            .then(function (response) {
              console.log(response);
            })
            // console.log('checking')
          }
        }
      }
    })
  </script>
@endsection