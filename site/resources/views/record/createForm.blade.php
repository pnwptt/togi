@extends('layouts.master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.css') }}">
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
    .float-right {
      float: right;
    }
    .pd-b-8 {
      padding-bottom: 8px;
    }
    .clickable {
      cursor: pointer;
    }
    button.float-right {
      margin-left: 5px;
    }
  </style>
@endsection

@section('content')
  <div id="app">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-11"><h4>Create PPA Inspection Record Form</h4></div>
        <div class="col-md-1 pd-b-8"><button class="btn btn-success btn-block" @click="save()">Save</button></div>
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
                        <input type="text" class="form-control" autofocus v-model="record.c_order_number" @keyup="findChecklist($event)">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Part number:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="record.c_part_number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Series:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.c_series">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Customer:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="record.c_customer">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Quantity:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" v-model="record.i_qty">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Sampling Qty:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" disabled v-model="record.i_sampling_qty">
                      </div>
                    </div>
                  </td>
                  <td width="34%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Model:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled v-model="record.models">
                      </div>
                    </div>
                    <h6>Refference to WI-QA-001</h6>
                    <hr>
                    <h5 class="header-italic">Lot Judgement</h5>
                    <div class="form-group" align="center">
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" v-model="record.judgement" value="1" id="judgementAccept">
                        <label class="custom-control-label" for="judgementAccept">Accept</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" v-model="record.judgement" value="-1" id="judgementReject">
                        <label class="custom-control-label" for="judgementReject">Reject</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">NCR No.</label>
                      
                      <div class="col-sm-8">
                        <input type="text" class="form-control" :disabled="record.judgement != -1" v-model="record.c_ncr_number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">8D Report No.</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" :disabled="record.judgement != -1" v-model="record.c_8d_report_no">
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
                      <input type="text" class="form-control input-machine" id="input-machineNo" :disabled="!record.c_series" v-model="machineNo" @keyup.enter="addMachine()">
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
                    <th class="machineList" v-if="record.machineList.length == 0"></th>
                  </tr>
                  <!-- ============================================= Mesurement ======================================== -->
                    <tr>
                      <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7" class="table-light"><i>Mesurement</i></td>
                    </tr>
                    <tr v-for="(cl, index) in record.mesurementChecklist" v-show="record.mesurementChecklist.length > 0">
                      <td align="center">@{{ index + 1 }}</td>
                      <td align="center">@{{ cl.c_rank }}</td>
                      <td align="center">@{{ cl.c_code }}</td>
                      <td>@{{ cl.n_errorcode }}</td>
                      <td v-for="(item, i) in record.mesurement" v-if="item.i_checklist_id == cl.i_checklist_id">
                        <input type="text" class="form-control" v-model="item.value" @blur="checkError(i, item.checklistIndex, 'mesurement')">
                      </td>
                      <td v-if="record.machineList.length == 0"></td>
                      <td><input type="text" class="form-control" v-model="record.mesurementRejectDetail[index].value" v-if="record.mesurementRejectDetail.length > 0"></td>
                      <td align="center">@{{ totalByErrorcode(index, 'mesurement') }}</td>
                    </tr>
                    <tr v-show="record.mesurementChecklist.length == 0">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <!-- ============================================= Mesurement ======================================== -->


                  <!-- ========================================== Test Specification =================================== -->
                    <tr>
                      <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7" class="table-light"><i>Test Specification</i></td>
                    </tr>
                    <tr v-for="(cl, index) in record.testSpecificationChecklist" v-show="record.testSpecificationChecklist.length > 0">
                      <td align="center">@{{ index + 1 }}</td>
                      <td align="center">@{{ cl.c_rank }}</td>
                      <td align="center">@{{ cl.c_code }}</td>
                      <td>@{{ cl.n_errorcode }}</td>
                      <td v-for="(item, i) in record.testSpecification" v-if="item.i_checklist_id == cl.i_checklist_id">
                        <input type="text" class="form-control" v-model="item.value" @blur="checkError(i, item.checklistIndex, 'testSpecification')">
                      </td>
                      <td v-if="record.machineList.length == 0"></td>
                      <td><input type="text" class="form-control" v-model="record.testSpecificationRejectDetail[index].value" v-if="record.testSpecificationRejectDetail.length > 0"></td>
                      <td align="center">@{{ totalByErrorcode(index, 'testSpecification') }}</td>
                    </tr>
                    <tr v-show="record.testSpecificationChecklist.length == 0">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <!-- ========================================== Test Specification =================================== -->


                  <!-- ========================================== Failure symotom ====================================== -->
                    <tr>
                      <td :colspan="record.machineList.length + 7 > 7 ? record.machineList.length + 7 : 7" class="table-light"><i>Failure symptom</i></td>
                    </tr>
                    <tr v-for="(cl, index) in record.failureSymptomChecklist">
                      <td align="center">@{{ index + 1 }}</td>
                      <td align="center">@{{ cl.c_rank }}</td>
                      <td align="center"><input type="text" class="form-control" v-model="cl.c_code"  @keyup="findErrorCode(index, $event)"></td>
                      <td>@{{ cl.n_errorcode }}</td>
                      <td v-for="(item, i) in record.failureSymptom" v-if="item.errorcodeIndex == index">
                        <input type="checkbox" class="form-control" v-model="item.value">
                      </td>
                      <td v-if="record.failureSymptom.length == 0" :colspan="record.machineList.length > 0 ? record.machineList.length : 1"></td>
                      <td><input type="text" class="form-control" v-model="record.failureSymptomRejectDetail[index].value" v-if="record.failureSymptomRejectDetail[index]"></td>
                      <td class="table-light"></td>
                    </tr>
                  <!-- ========================================== Failure symotom ====================================== -->


                  <tr>
                    <th colspan="4">Total</th>
                    <th v-for="(machine, index) in record.machineList">@{{ totalByMachineNo(index) }}</th>
                    <th v-if="record.machineList.length == 0"></th>
                    <th class="table-light"></th>
                    <th>@{{ total() }}</th>
                  </tr>
                  <tr>
                    <th colspan="4">Pallet#</th>
                    <th :colspan="palletDivide == 1 ? 1 : (record.machineList.length / 2) < (index + 1)  ? 1 : 2" v-for="(value, index) in record.palletList">
                      @{{ index + 1 }}
                    </th>
                    <th v-if="record.machineList.length == 0"></th>
                    <th rowspan="2">Total R/J (M/C)</th>
                    <td rowspan="2" align="center"><input type="number" class="form-control" id="total-rjmc" v-model="record.totalRJMC"></td>
                  </tr>
                  <tr>
                    <th colspan="4">Accept/Reject</th>
                    <th :colspan="palletDivide == 1 ? 1 : (record.machineList.length / 2) < (index + 1) ? 1 : 2" v-for="(value, index) in record.palletList" class="clickable"
                      :class="palletClass[value.status]"
                      @click="togglePalletStatus(index)"></th>
                    <th v-if="record.machineList.length == 0"></th>
                  </tr>
                </thead>
              </table>
              <div class="form-group">
                <label for="remark">Remark</label>
                <textarea class="form-control" id="exampleTextarea" rows="3" v-model="record.remark"></textarea>
              </div>
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
        showValidateLog: false,
        machineNo: '',
        palletClass: ['table-success', 'table-danger'],
        totalFailByMachine: [],
        palletDivide: 1,
        record: {
          models: '',
          c_order_number: '',
          c_part_number: '',
          c_series: '',
          c_customer: '',
          i_qty: 0,
          c_user: '{{ session()->get("c_user") }}',
          i_sampling_qty: 0,
          today: '{{ date("Y-m-d") }}',
          judgement: 0,
          c_ncr_number: '',
          c_8d_report_no: '',
          totalRJMC: 0,
          i_models_id: '',
          i_form_id: '',

          machineList: [],

          mesurementChecklist: [],
          mesurement: [],
          mesurementRejectDetail: [],

          testSpecificationChecklist: [],
          testSpecification: [],
          testSpecificationRejectDetail: [],

          failureSymptomChecklist: [],
          failureSymptom: [],
          failureSymptomRejectDetail: [],

          palletList: [],

          remark: ''
        }
      },

      mounted() {
        for (var i = 0; i < 5; i++) {
          this.record.failureSymptomChecklist.push({
            i_errorcode_id: '',
            c_rank: '',
            c_code: '',
            n_errorcode: ''
          });
        }
        //this.record.c_order_number = 'wo-123456'; // for dev
      },

      methods: {
        addMachine() {
          var machineNo = this.validateMachineNo(this.machineNo);
          if (machineNo) {
            this.record.machineList.push(machineNo);
            this.record.i_sampling_qt++;

            this.totalFailByMachine.push(0);

            if (this.palletDivide == 1 || this.record.machineList.length % 2 == 1) {
              this.record.palletList.push({
                status: 0
              });
            }

            this.record.mesurementChecklist.forEach((item, index) => {
              app.record.mesurement.push({
                machineNo: machineNo, 
                checklistIndex: index, 
                i_checklist_id: item.i_checklist_id, 
                value: '',
                fail: false
              });
            });
            this.record.testSpecificationChecklist.forEach((item, index) => {
              app.record.testSpecification.push({
                machineNo: machineNo, 
                checklistIndex: index, 
                i_checklist_id: item.i_checklist_id, 
                value: '',
                fail: false
              });
            });

            this.record.failureSymptomChecklist.forEach((item, index) => {
              app.record.failureSymptom.push({
                machineNo: machineNo,
                errorcodeIndex: index,
                i_errorcode_id: item.i_errorcode_id,
                c_rank: item.c_rank,
                value: false
              });
            });
            console.log('Added MachineNo [' + machineNo + '] to list');
            this.machineNo = '';
          }
        },

        findChecklist(event) {
          if (event.key == 'Enter') {
            if (this.record.c_order_number && !this.processing) {
              this.processing = true;
              axios.get('{{ route("findChecklist") }}', {
                params: {
                  c_workorder: this.record.c_order_number.toUpperCase()
                }
              })
              .then((response) => {
                if(response.data.record) {
                  window.location.href = '{{ route("editRecord") }}/' + response.data.record.c_order_number.trim();
                } else {
                  var workOrder = response.data.workOrder;
                  this.palletDivide = response.data.models.i_pallet_qty > 10 ? 2 : 1;
                  this.record.models = response.data.models.n_models_name;
                  this.record.i_models_id = response.data.models.i_models_id;
                  this.record.c_part_number = workOrder.c_item ? workOrder.c_item : '';
                  this.record.c_series = workOrder.c_series;
                  this.record.c_customer = workOrder.country;
                  this.record.mesurementChecklist = response.data.mesurementChecklist;
                  this.record.testSpecificationChecklist = response.data.testSpecificationChecklist;
                  this.record.i_form_id = response.data.form.i_form_id;
                  response.data.mesurementChecklist.forEach((item, index) => {
                    app.record.mesurementRejectDetail.push({
                      checklistIndex: index,
                      i_checklist_id: item.i_checklist_id,
                      value: ''
                    });
                  });
                  response.data.testSpecificationChecklist.forEach((item, index) => {
                    app.record.testSpecificationRejectDetail.push({
                      checklistIndex: index,
                      i_checklist_id: item.i_checklist_id,
                      value: ''
                    });
                  });
                  this.processing = false;
                }
              }).catch((error, response) => {
                alert('Order number is invalid or not found.');
                this.record.c_order_number = "";
                this.processing = false;
              });
            }
          } else {
            this.record.models = '';
            this.record.c_part_number = '';
            this.record.c_series = '';
            this.record.c_customer = '';
            this.record.i_qty = 0;
            this.record.i_sampling_qty = 0;
            this.record.judgement = 0;
            this.record.i_models_id = '';
            this.record.machineList = [];
            this.record.mesurementChecklist = [];
            this.record.mesurement = [];
            this.record.mesurementRejectDetail = [];
            this.record.testSpecificationChecklist = [];
            this.record.testSpecification = [];
            this.record.testSpecificationRejectDetail = [];
            this.record.failureSymptom = [];
            this.record.palletList = [];
            this.record.totalRJMC = 0;
            this.totalFailByMachine = [];
            this.record.i_form_id = '';
          }
        },

        findErrorCode(index, event) {
          if (event.key == 'Enter') {
            axios.get('{{ route("findErrorcode") }}', {
              params: {
                c_code: this.record.failureSymptomChecklist[index].c_code
              }
            })
            .then((response) => {
              var errorcode = response.data;
              this.record.failureSymptomChecklist[index].i_errorcode_id = errorcode.i_errorcode_id;
              this.record.failureSymptomChecklist[index].c_rank = errorcode.c_rank;
              this.record.failureSymptomChecklist[index].n_errorcode = errorcode.n_errorcode;
              this.record.failureSymptomRejectDetail[index] = {
                i_errorcode_id: errorcode.i_errorcode_id,
                errorcodeIndex: index,
                value: ''
              };

              this.record.failureSymptom.forEach((item) => {
                if (item.errorcodeIndex == index) {
                  item.i_errorcode_id = errorcode.i_errorcode_id;
                  item.c_rank = errorcode.c_rank;
                }
              });
            });
          } else {
            this.record.failureSymptomRejectDetail[index] = null;
            this.record.failureSymptomChecklist[index].i_errorcode_id = null;
            this.record.failureSymptomChecklist[index].c_rank = null;
            this.record.failureSymptomChecklist[index].n_errorcode = null;
          }
        },

        save() {
          if (this.record.machineList.length == 0) {
            alert('Please enter at least one machine.');
            $('#input-machineNo').focus();
          } else if (this.record.judgement == 0) {
            alert('Please select lot judgement.');
          } else {
            this.processing = true;
            axios.post('{{ route("createRecord") }}', this.record)
            .then((response) => {
              alert('Saved.');
              window.location.href = '{{ route("record") }}';
              this.processing = false;
            })
            .catch((error) => {
              alert('Ops! Something went wrong.');
              this.processing = false;
            });
          }
        },

        // ====================================== Calulate Section ======================================
          checkError(index, checklistIndex, type) {
            switch(type) {
              case 'mesurement':
                var value = this.record.mesurement[index].value;
                if (value) {
                  var min = this.record.mesurementChecklist[checklistIndex].f_min_value;
                  var max = this.record.mesurementChecklist[checklistIndex].f_max_value;
                  
                  this.record.mesurement[index].fail = 
                    (min && Number(value) < Number(min)) || (max && Number(value) > Number(max)) 
                    ? true : false;
                }
                break;
              case 'testSpecification':
                var value = this.record.testSpecification[index].value;
                if (value) {
                  var min = this.record.testSpecificationChecklist[checklistIndex].f_min_value;
                  var max = this.record.testSpecificationChecklist[checklistIndex].f_max_value;
                  this.record.testSpecification[index].fail = 
                    (min && Number(value) < Number(min)) || (max && Number(value) > Number(max)) 
                    ? true : false;
                }
                break;
            }
          },

          togglePalletStatus(index) {
            this.record.palletList[index].status = this.record.palletList[index].status == 0 ? 1 : 0;
          },

          rotateClass() {
            return this.record.machineList.length > 4 ? 'rotate-90' : '';
          },

          isInArray(value, array) {
            return array.indexOf(value) > -1;
          },

          totalByMachineNo(index) {
            var total = 0, m = [], t = [], f = [];
            m = this.record.mesurement.filter((m) => m.machineNo == this.record.machineList[index] && m.fail);
            t = this.record.testSpecification.filter((m) => m.machineNo == this.record.machineList[index] && m.fail);
            f = this.record.failureSymptom.filter((m) => m.machineNo == this.record.machineList[index] && m.value);
            total = m.length + t.length + f.length;
            this.totalFailByMachine[index] = total;
            return total;
          },

          totalByErrorcode(index, type) {
            var list = [];
            switch(type) {
              case 'mesurement':
                list = this.record.mesurement.filter((machine, i) => machine.checklistIndex == index && machine.value && machine.fail);
                break;
              case 'testSpecification':
                list = this.record.testSpecification.filter((machine, i) => machine.checklistIndex == index && machine.value && machine.fail);
                break;
            }
            return list.length;
          },

          total() {
            var total = 0;
            if (this.totalFailByMachine.length > 0) {
              total = this.totalFailByMachine.reduce((current, next) => current + next);
            }
            return total;
          },
        // ====================================== Calulate Section ======================================


        // ====================================== Validate Section ======================================
          validateMachineNo(value) {
            this.showValidateLog && console.warn('Validate is Starting :: Checking value = [' + value + ']');

            var newValue = this.formatedMachineNo(value);
            var machineNo = undefined;
            if (newValue) {
              if (this.checkModels(newValue[0]) && this.checkIsExistMachineNo(newValue[1])) {
                machineNo = newValue[1];
              }
            }
            this.showValidateLog && console.warn('Validat Ended :: Current MachineNo = [' + machineNo + ']');
            return machineNo;
          },

          checkModels(value) {
            this.showValidateLog && console.log('=> Checking Models :: Current Models = [' + value + '], Expect Models = [' + this.record.c_series + ']');

            if (value == this.record.c_series.trim()) {
              this.showValidateLog && console.log(' -> Models is ok :: Models value = [' + value + '=' + this.record.c_series + ']');
              return true;
            }
            console.error(' -> Models is invalid :: [' + value + '!=' + this.record.c_series + ']');
            return false;
          },

          checkIsExistMachineNo(value) {
            this.showValidateLog && console.log('=> Checking MachineNo :: Current MachineNo = [' + value + '], Current List = [' + this.record.machineList + ']');

            if (!this.isInArray(value, this.record.machineList)) {
              this.showValidateLog && console.log(' -> MachineNo is not exist :: Checked value = [' + value + ']');
              return true;
            }
            this.showValidateLog && console.error(' -> MachineNo is exist :: MachineNo = [' + value + '], Current List = [' + this.record.machineList + ']');
            this.machineNo = '';
            return false;
          },

          formatedMachineNo(value) {
            this.showValidateLog && console.log('=> Checking format :: Current value = [' + value + ']');

            var newValue = value.split(' ');
            if (newValue.length == 2) {
              var models = newValue[0]; var machineNo = newValue[1];
              if (
                this.checkLength('Models', models.length, 3) &&
                this.checkLength('MachineNo', machineNo.length, 8) &&
                this.checkIsNumber('Models', models) &&
                this.checkIsNumber('MachineNo', machineNo)
              ) {
                this.showValidateLog && console.log(' -> MachineNo format is ok :: Current value = [' + newValue + ']');
                return newValue;
              }
            }
            this.showValidateLog && console.error(' -> MachineNo format is invalid :: Current value = [undefined]');
            return undefined;
          },

          checkIsNumber(type, value) {
            this.showValidateLog && console.log('  => Checking ' + type + ' is number :: Current value = [' + value + ']');

            if (! isNaN(Number(value))) {
              this.showValidateLog && console.log('    -> ' + type + ' is number :: ' + type + ' = [' + value +']');
              return true;
            }
            this.showValidateLog && console.error('    -> ' + type + ' is not number :: ' + type + ' = [NaN]');
            return false;
          },

          checkLength(type, length, expect) {
            this.showValidateLog && console.log('  => Checking ' + type + ' length :: Length = [' + length + '], Expect = [' + expect + ']');

            if (length == expect) {
              this.showValidateLog && console.log('    -> ' + type + ' length is ok :: [' + length + '=' + expect + ']');
              return true;
            }
            this.showValidateLog && console.error('    -> ' + type + ' length is invalid :: [' + length + '!=' + expect + ']');
            return false;
          }
        // ====================================== Validate Section ======================================

      },


      watch: {
        'record.judgement': function (newValue, oldValue) {
          switch(newValue) {
            case 0:
            case 1:
              this.record.c_ncr_number = '';
              this.record.c_8d_report_no = '';
              break;
            default:
          }
        }
      }
    });
  </script>
@endsection