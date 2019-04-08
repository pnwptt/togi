@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h3>Lot Inspection Result</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createRecordForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-light">
                <th>Oder No.</th>
                <th>Insp. Date</th>
                <th>P/N</th>
                <th>Destination</th>
                <th>Order Qty (m/c)</th>
                <th>Insp. Qty (m/c)</th>
                <th>R/J Qty (m/c)</th>
                <th>Pallet Qty</th>
                <th>Rework</th>

              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection