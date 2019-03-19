@extends('layouts.master')

@section('css')
  <style type="text/css">
    .active {
      padding-right: 10px;
      color: green;
    }
    .inactive {
      color: gray;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-11"><h3>Check List</h3></div>
      <div class="col-sm-1">
        <a href="{{ route('createChecklistForm') }}" class="btn btn-success btn-ms btn-block">Add</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr class="table-light">
                <!-- <th>#</th> -->
                <th>Models</th>
                <th>Create Date</th>
                <th>Effective Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($forms as $value)
                <tr>
                  <!-- <td align="center">{{ $value->i_form_id }}</td> -->
                  <td align="center">{{ isset($value->getModels->n_models_name) ? $value->getModels->n_models_name : '' }}</td>
                  <td align="center">{{ $value->d_form_created }}</td>
                  <td align="center">{{ $value->d_effective_date }}</td>
                  <td align="center">
                    <div class="form-group">
                      <div class="custom-control custom-switch" onclick="return !processing && {{isset($value->getModels->n_models_name) ? 1 : 0}} == 1">
                        <input type="checkbox" class="custom-control-input" id="status-{{ $value->i_form_id }}"
                          onchange="updateStatus('{{ $value->i_form_id }}', '{{ $value->i_status ? 0 : 1}}')" {{ $value->i_status ? 'checked' : '' }}>
                        @if($value->i_status)
                          <label class="custom-control-label active" for="status-{{ $value->i_form_id }}">Active</label>
                        @else
                          <label class="custom-control-label inactive" for="status-{{ $value->i_form_id }}">Inactive</label>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td align="center">
                    @if($value->i_status == 0 && !$value->d_effective_date)
                      <a href="{{ route('editChecklistForm', $value->i_form_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @elseif($value->d_effective_date)
                      <a href="{{ route('viewChecklistForm', $value->i_form_id) }}" class="btn btn-info btn-sm">View</a>
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