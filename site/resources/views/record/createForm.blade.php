@extends('layouts.master')

@section('css')
  <style>
    .container-fluid {
      padding-bottom: 50px;
    }
    .header-italic {
      text-align: center;
      font-style: italic;
    }
    .custom-radio {
      display: inline-block;
      margin: 10px;
    }
    .table thead th {
      vertical-align: middle;
      padding: 5px 0;
    }
    .rotate-90 {
      -webkit-transform: rotate(-90deg); 
      -moz-transform: rotate(-90deg);
    }
    .input-machine {
      margin: 0 5px;
      width: 50%;
      display: inline-block;
    }
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    .top {
      position: absolute;
      margin-right: -25px;
    }
    .clear-machine {
      position: absolute;
      color: red;
      font-size: 18pt;
    }
    .clear-machine:hover {
      cursor: pointer;
    }
    .machineList {
      height: 100px;
    }
  </style>
@endsection

@section('content')
  <div id="app">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12"><h4>Create PPA Inspection Record Form</h4></div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <table class="table table-bordered">
                <thead>
                  <td width="33%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Order number:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" autofocus v-model="record.c_order_number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Part number:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.c_part_number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Part name:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.c_part_name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Customer:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.c_customer">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Quantity:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.i_qty">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Sampling Qty:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" v-model="record.i_sampling_qty">
                      </div>
                    </div>
                  </td>
                  <td width="34%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Model:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.series">
                      </div>
                    </div>
                    <h6>Refference to WI-QA-001</h6>
                    <hr>
                    <h5 class="header-italic">Lot Judgement</h5>
                    <div class="form-group" align="center">
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="judgement" id="judgementAccept" :checked="judgement == 1" onclick="return false">
                        <label class="custom-control-label" for="judgementAccept">Accept</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="judgement" id="judgementReject" :checked="judgement == -1" onclick="return false">
                        <label class="custom-control-label" for="judgementReject">Reject</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">NCR No.</label>
                      
                      <div class="col-sm-8">
                        <input type="text" class="form-control" :disabled="judgement != -1" v-model="record.c_ncr_number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">8D Report No.</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" :disabled="judgement != -1" v-model="record.c_8d_report_no">
                      </div>
                    </div>
                  </td>
                  <td width="33%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Check by</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" disabled v-model="record.c_user">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Date:</label>
                      <div class="col-sm-8">
                          <input type="date" class="form-control" disabled v-model="record.today">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Approved by</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Date:</label>
                      <div class="col-sm-8">
                          <input type="date" class="form-control" disabled>
                      </div>
                    </div>
                  </td>
                </thead>
              </table>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="2" width="6%"><div class="rotate-90">Item no.</div></th>
                    <th rowspan="2" width="6%"><div class="rotate-90">Rank</div></th>
                    <th rowspan="2" width="6%"><div class="rotate-90">Errorcode</div></th>
                    <th rowspan="2" width="20%">Inspection detail</th>
                    <th :colspan="record.machineList.length > 0 ? record.machineList.length : 1">
                      Machine no. 
                      <input type="text" class="form-control input-machine" :disabled="!record.c_part_name" v-model="machineNo" @keyup.enter="addMachine">
                      <span class="clear-machine" v-show="machineNo" @click="machineNo = ''">X</span>
                    </th>
                    <th rowspan="2" width="20%">Reject detail</th>
                    <th rowspan="2" width="6%">Total</th>
                  </tr>
                  <tr>
                    <th class="machineList" v-for="(machineNo, index) in record.machineList">
                      <div :class="rotateClass()">
                        @{{ machineNo }}
                      </div>
                    </th>
                    <th class="machineList" v-if="record.machineList.length < 1"></th>
                  </tr>
                  <tr>
                    <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7"><i>Mesurement</i></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7"><i>Test Specification</i></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7"><i>Failure symotom</i></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th colspan="4">Total</th>
                    <th :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></th>
                    <th></th>
                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="4">Pallet#</th>
                    <th :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></th>
                    <th rowspan="3">Total R/J (M/C)</th>
                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="4">Accept</th>
                    <th :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></th>
                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="4">Reject</th>
                    <th :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></th>
                    <th></th>
                  </tr>
                </thead>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        machineNo: '',
        judgement: 0,
        record: {
          c_user: '{{ session()->get("c_user") }}',
          series: '',
          today: '{{ date("Y-m-d") }}',
          c_order_number: '',
          c_part_number: '',
          c_part_name: '590',
          c_customer: '',
          i_qty: '',
          i_sampling_qty: 0,
          c_ncr_number: '',
          c_8d_report_no: '',
          machineList: [],
        }
      },

      methods: {
        addMachine() {
          var machineNo = this.validateMachineNo(this.machineNo);
          if (machineNo) {
            this.record.machineList.push(machineNo);
            console.log('Added MachineNo [' + machineNo + '] to list');
            this.machineNo = '';
          }
        },

        rotateClass() {
          return this.record.machineList.length > 4 ? 'rotate-90' : '';
        },

        isInArray(value, array) {
          return array.indexOf(value) > -1;
        },





        // ====================================== Validate Section ======================================

        validateMachineNo(value) {
          console.warn('Validate is Starting :: Checking value = [' + value + ']');

          var newValue = this.formatedMachineNo(value);
          var machineNo = undefined;
          if (newValue) {
            if (this.checkSeries(newValue[0]) && this.checkIsExistMachineNo(newValue[1])) {
              machineNo = newValue[1];
            }
          }
          console.warn('Validat Ended :: Current MachineNo = [' + machineNo + ']');
          return machineNo;
        },

        checkSeries(value) {
          console.log('=> Checking Series :: Current Series = [' + value + '], Expect Series = [' + this.record.c_part_name + ']');

          if (value == this.record.c_part_name) {
            console.log(' -> Series is ok :: Series value = [' + value + '=' + this.record.c_part_name + ']');
            return true;
          }
          console.error(' -> Series is invalid :: [' + value + '!=' + this.record.c_part_name + ']');
          return false;
        },

        checkIsExistMachineNo(value) {
          console.log('=> Checking MachineNo :: Current MachineNo = [' + value + '], Current List = [' + this.record.machineList + ']');

          if (!this.isInArray(value, this.record.machineList)) {
            console.log(' -> MachineNo is not exist :: Checked value = [' + value + ']');
            return true;
          }
          console.error(' -> MachineNo is exist :: MachineNo = [' + value + '], Current List = [' + this.record.machineList + ']');
          this.machineNo = '';
          return false;
        },

        formatedMachineNo(value) {
          console.log('=> Checking format :: Current value = [' + value + ']');

          var newValue = value.split(' ');
          if (newValue.length == 2) {
            var series = newValue[0]; var machineNo = newValue[1];
            if (
              this.checkLength('Series', series.length, 3) &&
              this.checkLength('MachineNo', machineNo.length, 8) &&
              this.checkIsNumber('Series', series) &&
              this.checkIsNumber('MachineNo', machineNo)
            ) {
              console.log(' -> MachineNo format is ok :: Current value = [' + newValue + ']');
              return newValue;
            }
          }
          console.error(' -> MachineNo format is invalid :: Current value = [undefined]');
          return undefined;
        },

        checkIsNumber(type, value) {
          console.log('  => Checking ' + type + ' is number :: Current value = [' + value + ']');

          if (! isNaN(Number(value))) {
            console.log('    -> ' + type + ' is number :: ' + type + ' = [' + value +']');
            return true;
          }
          console.error('    -> ' + type + ' is not number :: ' + type + ' = [NaN]');
          return false;
        },

        checkLength(type, length, expect) {
          console.log('  => Checking ' + type + ' length :: Length = [' + length + '], Expect = [' + expect + ']');

          if (length == expect) {
            console.log('    -> ' + type + ' length is ok :: [' + length + '=' + expect + ']');
            return true;
          }
          console.error('    -> ' + type + ' length is invalid :: [' + length + '!=' + expect + ']');
          return false;
        }

        // ====================================== Validate Section ======================================

      }
    });
  </script>
@endsection