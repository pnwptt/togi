@extends('layouts.master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
  <style type="text/css">
    table {
      border-radius: 0;
      padding: 0;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
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
    <div class="row">
      <div class="col-sm-11"><h3>Lot Inspection Result</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createRecordForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered" id="datatables">
            <thead>
              <tr class="table-light">
                <th>Model</th>
                <th>Oder No.</th>
                <th>Insp. Date</th>
                <th>P/N</th>
                <th>Destination</th>
                <th>Order Qty (m/c)</th>
                <th>Insp. Qty (m/c)</th>
                <th>R/J Qty (m/c)</th>
                <th>Pallet Qty</th>
                <th>Rework</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($records as $record)
                <tr>
                  <td>{{ $record->n_models_name }}</td>
                  <td>{{ $record->c_order_number }}</td>
                  <td>{{ $record->insp_date }}</td>
                  <td>{{ $record->c_part_number }}</td>
                  <td>{{ $record->c_customer }}</td>
                  <td>{{ $record->i_qty }}</td>
                  <td>{{ $record->sampling_qty }}</td>
                  <td>{{ $record->total_rjmc }}</td>
                  <td>{{ $record->pallet_qty }}</td>
                  <td>{{ $record->rework }}</td>
                  <td>{{ $record->d_approve_date ? 'Approved' : '' }}</td>
                  <td>
                    <a href="{{ route('viewRecord', trim($record->c_order_number)) }}" class="btn-sm btn-info">View</a>
                    @if($record->can_edit)
                      <a href="{{ route('editRecordForm', trim($record->c_order_number)) }}" class="btn-sm btn-warning">Edit</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
  <script type="text/javascript">
    $('#datatables').DataTable({
      sorting: [[1, 'desc']]
    });
  </script>
@endsection