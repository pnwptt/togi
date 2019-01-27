@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-5"><h4>Create PPA Inspection Record Form</h4></div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-12">
        <form action="{{ route('createRecord') }}" method="post" class="form form-horizontal">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <td>
                  <label>Order number:
                  <input type="text" class="form-control" name="c_order_number" required></label><br>
                  <label>Part number:
                  <input type="text" class="form-control" name="c_part_number" required></label><br>
                  <label>Part name:
                  <input type="text" class="form-control" name="c_part_name" required></label><br>
                  <label>Customer:
                  <input type="text" class="form-control" name="c_customer" required></label><br>
                  <label>Quantity:
                  <input type="text" class="form-control" name="i_qty" required></label><br>
                  <label>Sampling Qty:
                  <input type="text" class="form-control" name="i_sampling_qty" required></label>
                </td>
                <!-- <td>
                  <input type="text" class="form-control" name="c_order_number" required><br>
                  <input type="text" class="form-control" name="c_part_number" required><br>
                  <input type="text" class="form-control" name="c_part_name" required><br>
                  <input type="text" class="form-control" name="c_customer" required><br>
                  <input type="text" class="form-control" name="i_qty" required><br>
                  <input type="text" class="form-control" name="i_sampling_qty" required>
                </td> -->
                <td>
                  <b>Refference to WI-QA-001<hr>
                  <i>Lot Judgement</i><br></b>
                  <label>
                    <input type="radio" name="" value="Accept">
                    <input type="radio" name="" value="Reject"><br>
                    NCR No. <input type="text" class="form-control" name="c_ncr_number">
                    8D Report No. <input type="text" class="form-control" name="c_8d_report_no">
                  </label>
                </td>
                <td>
                  <label>Check by <input type="text" class="form-control"></label><br>
                  <label>Date: <input type="date" class="form-control"></label><br>
                  <label>Approved by <input type="text" class="form-control"></label><br>
                  <label>Date: <input type="date" class="form-control"></label>
                </td>
              </thead>
            </table>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>

@endsection