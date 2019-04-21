@extends('layouts.master')

@section('css')
  <style type="text/css">
    .empty {
      color: gray;
    }
  </style>
@endsection

@section('content')
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-4"><h4>Create Checklist</h4></div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <div class="form form-horizontal">
            <div class="form-group">
              <label><b>Models</b></label>
              <select class="form-control" v-model="currentModels">
                <option value="" disabled selected>- Select Models -</option>
                @foreach($modelList as $m)
                  <option value="{{ $m->i_models_id }}">{{ $m->n_models_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <div class="form form-horizontal">
            <div class="form-group">
              <label><b>Errorcode</b></label>
              <input type="text" class="form-control" id="currentErrorcode" placeholder="Enter Errorcode" 
                list="errorcode" 
                v-model="currentErrorcode">
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form form-horizontal">
            <div class="form-group">
              <label><b>Minimum Value</b></label>
              <input type="number" class="form-control" placeholder="Enter Min Value" v-model="currentMin">
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form form-horizontal">
            <div class="form-group">
              <label><b>Maximum Value</b></label>
              <input type="number" class="form-control" placeholder="Enter Max Value" v-model="currentMax">
            </div>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form form-horizontal">
            <label><b>Action</b></label>
            <div class="form-group" align="center">
              <button type="button" class="btn btn-success btn-block" @click="addErrorcode()">Add</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="table-dark">
                  <th>Errorcode</th>
                  <th>Measurement</th>
                  <th>Minimum Value</th>
                  <th>Maximum Value</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in errorcodeList" v-if="item.type == 1">
                  <td align="center">@{{ item.code }}</td>
                  <td align="left">@{{ item.name }}</td>
                  <td align="center">@{{ item.min }}</td>
                  <td align="center">@{{ item.max }}</td>
                  <td align="center">
                    <button type="button" class="btn btn-danger btn-sm" @click="removeErrorcode(index)">Remove</button>
                  </td>
                </tr>
                <tr v-if="errorcodeList.filter(isMeasurement).length == 0">
                  <td align="center" colspan="6"><i class="empty">Empty</i></td>
                </tr>
                <tr class="table-dark">
                  <th>Errorcode</th>
                  <th>Test Specification</th>
                  <th>Maximum Value</th>
                  <th>Minimum Value</th>
                  <th>Action</th>
                </tr>
                <tr v-for="(item, index) in errorcodeList" v-if="item.type == 2">
                  <td align="center">@{{ item.code }}</td>
                  <td align="left">@{{ item.name }}</td>
                  <td align="center">@{{ item.min }}</td>
                  <td align="center">@{{ item.max }}</td>
                  <td align="center">
                    <button type="button" class="btn btn-danger btn-sm" @click="removeErrorcode(index)">Remove</button>
                  </td>
                </tr>
                <tr v-if="errorcodeList.filter(isTestSpecification).length == 0">
                  <td align="center" colspan="6"><i class="empty">Empty</i></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="form-horizontal">
            <div class="form-group" align="center">
              <button type="button" class="btn btn-success" @click="createForm">Create</button>
              <a href="{{ route('checklist') }}" class="btn btn-light">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <datalist id="errorcode">
      @foreach($errorcode as $e)
        <option value="{{ $e->c_code }}">{{ $e->n_errorcode }}</option>
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
        currentModels: '',
        currentErrorcode: '',
        currentMin: '',
        currentMax: '',
        errorcodeList: [],
        processing: false
      },
      methods: {
        isMeasurement(element) {
          return element.type == 1;
        },

        isTestSpecification(element) {
          return element.type == 2;
        },

        isOnList(element) {
          return element.code == this.currentErrorcode;
        },

        addErrorcode() {
          if (this.currentErrorcode && !this.processing) {
            this.processing = true;
            axios.get('{{ route("checkerrorcode") }}', {
              params: {
                code: this.currentErrorcode
              }
            })
            .then((response) => {
              if (response.data) {
                if (this.errorcodeList.filter(this.isOnList).length == 0) {
                  this.errorcodeList.push({
                    id: response.data.i_errorcode_id,
                    code: response.data.c_code,
                    name: response.data.n_errorcode,
                    type: response.data.i_errorcode_type_id,
                    min: this.currentMin,
                    max: this.currentMax
                  });
                } else {
                  alert('This Errorcode is already in list.');
                }
              } else {
                alert('This Errorcode has invalid type.');
              }
              this.currentErrorcode = '';
              this.currentMin = '';
              this.currentMax = '';
              this.processing = false;
            })
            .catch((error) => {
              alert('Ops! Something went wrong.');
              app.processing = false;
            });
          }
        },

        removeErrorcode(index) {
          this.errorcodeList.splice(index,1);
        },

        createForm() {
          if (confirm('Confirm?') && !this.processing) {
            this.processing = true;
            axios.post('{{ route("createChecklist") }}', {
              i_models_id: app.currentModels,
              errorcodeList: app.errorcodeList
            })
            .then((response) => {
              window.location.href = '{{ route("checklist") }}';
              app.processing = false;
            })
            .catch((error) => {
              alert('Ops! Something went wrong');
              app.processing = false;
            });
          }
        }
      }
    });
  </script>
@endsection