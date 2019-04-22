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
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-11"><h4>PPA Inspection Record</h4></div>
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
                        <input type="text" class="form-control" disabled value="{{ $record->c_order_number }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Part number:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->c_part_number }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Series:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->c_series }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Customer:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->c_customer }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Quantity:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" disabled value="{{ $record->i_qty }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Sampling Qty:</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" disabled value="{{ $i_sampling_qty }}">
                      </div>
                    </div>
                  </td>
                  <td width="34%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Model:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->n_models_name }}">
                      </div>
                    </div>
                    <h6>Refference to WI-QA-001</h6>
                    <hr>
                    <h5 class="header-italic">Lot Judgement</h5>
                    <div class="form-group" align="center">
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" onclick="return false" type="radio" value="1" id="judgementAccept" {{ $record->i_judgement == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="judgementAccept">Accept</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" onclick="return false" type="radio" value="-1" id="judgementReject" {{ $record->i_judgement == -1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="judgementReject">Reject</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">NCR No.</label>
                      
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->c_ncr_number }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4">8D Report No.</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" disabled value="{{ $record->c_8d_report_no }}">
                      </div>
                    </div>
                  </td>
                  <td width="33%">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Check by</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" disabled value="@foreach($c_checkby as $key => $value)@if($key != 0), @endif{{$value}}@endforeach">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Date:</label>
                      <div class="col-sm-8">
                          <input type="date" class="form-control" disabled value="{{ $record->d_record_date }}">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Approved by</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" disabled value="{{ $record->c_approveby }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Date:</label>
                      <div class="col-sm-8">
                          <input type="date" class="form-control" disabled value="{{ $record->c_approve_date }}">
                      </div>
                    </div>
                    @if(session()->get('admin') && !$record->c_approve_date)
                      <hr>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <a href="{{ route('approveRecord', $record->c_order_number) }}" onclick="return confirm('Approve {{$record->c_order_number}}?')" class="btn btn-primary btn-block">APPROVE</a>
                        </div>
                      </div> 
                    @endif
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
                    <th colspan="{{ count($machineList) > 1 ? count($machineList) : 1 }}">Machine no.</th>
                    <th rowspan="2" width="20%">Reject detail</th>
                    <th rowspan="2" width="6%">Total</th>
                  </tr>
                  <tr>
                    @foreach($machineList as $value)
                      <th class="machineList">
                        <div class="{{ count($machineList) > 4 ? 'rotate-90' : '' }}">
                          {{ $value }}
                        </div>
                      </th>
                      @php($totalFailByMachine[$value] = 0)
                      @php($totalA[$value] = 0)
                      @php($totalB[$value] = 0)
                      @php($totalC[$value] = 0)
                    @endforeach
                    @if(count($machineList) == 0)
                      <th class="machineList"></th>
                    @endif
                  </tr>
                  <!-- ============================================= Mesurement ======================================== -->
                    <tr>
                      <td colspan="{{ count($machineList) + 7 > 7 ? count($machineList) + 7 : 7 }}" class="table-light"><i>Mesurement</i></td>
                    </tr>
                    @foreach($mesurementChecklist as $index => $value)
                      <tr>
                        <td align="center">{{ $index + 1 }}</td>
                        <td align="center">{{ $value->c_rank }}</td>
                        <td align="center">{{ $value->c_code }}</td>
                        <td>{{ $value->n_errorcode }}</td>
                        @php($totalMesurementErrorcodeFail = 0)
                        @foreach($recordMesurementItems as $i => $v)
                          @if($value->i_checklist_id == $v->i_checklist_id)
                            @php($totalMesurementErrorcodeFail += $v->i_record_item_fail)
                            @php($totalFailByMachine[$v->c_machine_no] += $v->i_record_item_fail)
                            <td align="center">
                              {{ $v->i_record_item_value > 999 ? number_format($v->i_record_item_value) : $v->i_record_item_value }}
                            </td>
                          @endif
                        @endforeach
                        @if(count($machineList) == 0)
                          <td></td>
                        @endif
                        <td>{{ $recordMesurementDetails[$index]->c_detail }}</td>
                        <td align="center">{{ $totalMesurementErrorcodeFail }}</td>
                      </tr>
                    @endforeach
                    @if(count($mesurementChecklist) == 0)
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    @endif
                  <!-- ============================================= Mesurement ======================================== -->
                  
                  <!-- ========================================== Test Specification =================================== -->
                    <tr>
                      <td colspan="{{ count($machineList) + 7 > 7 ? count($machineList) + 7 : 7 }}" class="table-light"><i>Mesurement</i></td>
                    </tr>
                    @foreach($testSpecificationChecklist as $index => $value)
                      <tr>
                        <td align="center">{{ $index + 1 }}</td>
                        <td align="center">{{ $value->c_rank }}</td>
                        <td align="center">{{ $value->c_code }}</td>
                        <td>{{ $value->n_errorcode }}</td>
                        @php($totalTestSpecificationErrorcodeFail = 0)
                        @foreach($recordTestSpecificationItems as $i => $v)
                          @if($value->i_checklist_id == $v->i_checklist_id)
                            @php($totalTestSpecificationErrorcodeFail += $v->i_record_item_fail)
                            @php($totalFailByMachine[$v->c_machine_no] += $v->i_record_item_fail)
                            <td align="center">
                              {{ $v->i_record_item_value }}
                            </td>
                          @endif
                        @endforeach
                        @if(count($machineList) == 0)
                          <td></td>
                        @endif
                        <td>{{ $recordTestSpecificationDetails[$index]->c_detail }}</td>
                        <td align="center">{{ $totalTestSpecificationErrorcodeFail }}</td>
                      </tr>
                    @endforeach
                    @if(count($testSpecificationChecklist) == 0)
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    @endif
                  <!-- ========================================== Test Specification =================================== -->

                  <!-- ========================================== Failure symotom ====================================== -->
                    @if(count($recordFailure) != 0)
                      <tr>
                        <td colspan="{{ count($machineList) + 7 > 7 ? count($machineList) + 7 : 7 }}" class="table-light"><i>Mesurement</i></td>
                      </tr>
                      @foreach($failureSymptomChecklist as $index => $value)
                        <tr>
                          <td align="center">{{ $index + 1 }}</td>
                          <td align="center">{{ $value->c_rank }}</td>
                          <td align="center">{{ $value->c_code }}</td>
                          <td>{{ $value->n_errorcode }}</td>
                          @foreach($recordFailure as $i => $v)
                            @if($value->i_errorcode_id == $v->i_errorcode_id)
                              @if($value->c_rank == 'A' && $v->i_record_failure == 1)
                                @php($totalA[$v->c_machine_no]++)
                              @elseif($value->c_rank == 'B' && $v->i_record_failure == 1)
                                @php($totalB[$v->c_machine_no]++)
                              @elseif($value->c_rank == 'C' && $v->i_record_failure == 1)
                                @php($totalC[$v->c_machine_no]++)
                              @endif
                              <td align="center">
                                <input type="checkbox" class="form-control" onclick="return false" {{ $v->i_record_failure == 1 ? 'checked' : '' }}>
                              </td>
                            @endif
                          @endforeach
                          @if(count($machineList) == 0)
                            <td></td>
                          @endif
                          <td>{{ $recordFailureDetails[$index]->c_detail }}</td>
                          <td class="table-light"></td>
                        </tr>
                      @endforeach
                    @endif
                  <!-- ========================================== Failure symotom ====================================== -->

                  <tr>
                    <th colspan="4">Total</th>
                    @foreach($machineList as $value)
                      @php($totalFailByMachine[$value] += $totalA[$value] + floor($totalB[$value]/2) + floor($totalC[$value]/3))
                      <th>{{ $totalFailByMachine[$value] }}</th>
                    @endforeach
                    @if(count($machineList) == 0)
                      <th></th>
                    @endif
                    <th class="table-light"></th>
                    <th>-</th>
                  </tr>
                  <tr>
                    <th colspan="4">Pallet#</th>
                    @foreach($recordPallet as $index => $value)
                      <th colspan="{{ (count($machineList) / 2) < ($index + 1) ? 1 : 2 }}">
                        {{ $index + 1 }}
                      </th>
                    @endforeach
                    @if(count($machineList) == 0)
                      <th></th>
                    @endif
                    <th rowspan="2">Total R/J (M/C)</th>
                    <td rowspan="2" align="center">{{ $record->i_total_rjmc }}</td>
                  </tr>
                  <tr>
                    <th colspan="4">Accept/Reject</th>
                    @foreach($recordPallet as $index => $value)
                      <th colspan="{{ (count($machineList) / 2) < ($index + 1) ? 1 : 2 }}" class="{{ $value->i_record_pallet_status == 1 ? 'table-danger' : 'table-success' }}"></th>
                    @endforeach
                    @if(count($machineList) == 0)
                      <th></th>
                    @endif
                  </tr>
                </thead>
              </table>

              <div class="form-group">
                <label for="remark">Remark</label>
                <textarea class="form-control" id="exampleTextarea" rows="3" disabled>@foreach($c_remark as $value){{ $value }}
@endforeach</textarea>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection