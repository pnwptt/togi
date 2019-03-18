@extends('layouts.master')

@section('css')
  <style type="text/css">
    .empty {
      color: gray;
    }
    .active {
      padding-right: 10px;
      color: green;
    }
    .inactive {
      color: gray;
    }
    .mg-t-8 {
      margin-top: 8px;
    }
  </style>
@endsection

@section('content')
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-4"><h4>Checklist Details</h4></div>
      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <div class="form form-horizontal">
            <div class="form-group">
              <label><b>Series</b></label>
              <input type="text" class="form-control" value="{{ $form->getSeries->n_series_name }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <label><b>Status</b></label>
          <div class="custom-control custom-switch mg-t-8" onclick="return !processing && {{isset($form->getSeries->n_series_name) ? 1 : 0}} == 1">
            <input type="checkbox" class="custom-control-input" id="status-form"
              onchange="updateStatus('{{ $form->i_form_id }}', '{{ $form->i_status ? 0 : 1}}')" {{ $form->i_status ? 'checked' : '' }}>
            @if($form->i_status)
              <label class="custom-control-label active" for="status-form">Active</label>
            @else
              <label class="custom-control-label inactive" for="status-form">Inactive</label>
            @endif
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
                </tr>
              </thead>
              <tbody>
                @foreach($errorcodeListMeasurement as $item)
                  <tr>
                    <td align="center">{{ $item->c_code }}</td>
                    <td align="left">{{ $item->n_errorcode }}</td>
                    <td align="center">{{ $item->f_min_value }}</td>
                    <td align="center">{{ $item->f_max_value }}</td>
                  </tr>
                @endforeach
                @if(count($errorcodeListMeasurement) == 0)
                  <tr>
                    <td align="center" colspan="6"><i class="empty">Empty</i></td>
                  </tr>
                @endif
                <tr class="table-dark">
                  <th>Errorcode</th>
                  <th>Test Specification</th>
                  <th>Minimum Value</th>
                  <th>Maximum Value</th>
                </tr>
                @foreach($errorcodeListTestSpecification as $item)
                  <tr>
                    <td align="center">{{ $item->c_code }}</td>
                    <td align="left">{{ $item->n_errorcode }}</td>
                    <td align="center">{{ $item->f_min_value }}</td>
                    <td align="center">{{ $item->f_max_value }}</td>
                  </tr>
                @endforeach
                @if(count($errorcodeListTestSpecification) == 0)
                  <tr>
                    <td align="center" colspan="6"><i class="empty">Empty</i></td>
                  </tr>
                @endif
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
              <a href="{{ route('checklist') }}" class="btn btn-light">Back</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
  <script src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript">
    var processing = false;
    function updateStatus(id, status) {
      processing = true;
      if (processing) {
        axios.post('{{ route("statusChecklist") }}', 
          {
            i_form_id: id,
            i_status: status
          }
        ).then((res) => {
          window.location.reload();
          processing = false;
        })
        .catch((error) => {
          alert('Ops! Something went wrong');
          $('#status-' + id).prop('checked', Number(status) ? 1 : 0);
          processing = false;
        });
      }
    }
  </script>
@endsection
