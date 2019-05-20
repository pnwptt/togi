@extends('layouts.master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/chart.min.css') }}">
  <style type="text/css">
    table {
      border-radius: 0;
      padding: 0;
    }
    .chart {
      margin-bottom: 25px;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2">
        Model: 
        <select class="form-control" id="barModelId" onchange="onChangeModel('barModelId')">
          <option value="all">All</option>
          @foreach($models as $value)
            <option value="{{ $value->i_models_id }}">{{ $value->n_models_name }}</option>
          @endforeach
        </select>
      </div>
      <!-- <div class="col-md-2"></div> -->
      <div class="col-md-2">
        From: 
        <input type="date" class="form-control" id="barDateFrom">
      </div>
      <div class="col-md-2">
        To: 
        <input type="date"class="form-control" id="barDateTo">
      </div>
      <div class="col-md-2">
        Action: <br>
        <button type="button" class="btn btn-primary" onclick="reload()">Reload</button>
        <button type="button" class="btn btn-info" onclick="reset()">Reset</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"><center>PPA Inspection Report (% by Pallet)</center><canvas class="chart" id="palletBar" height="150"></canvas></div>
      <div class="col-md-6"><center>PPA Inspection Report (% by M/C)</center><canvas class="chart" id="machineBar" height="150"></canvas></div>
    </div>
    <div class="row">
      <div class="col-md-4"><br><h4 class="text-center">Total QTY : <span id="totalQty">{{ $totalQtyData }}</span></h4></div>
      <div class="col-md-2">
        Model: 
        <select class="form-control" id="lineModelId" onchange="onChangeModel('lineModelId')">
          <option value="all">All</option>
          @foreach($models as $value)
            <option value="{{ $value->i_models_id }}">{{ $value->n_models_name }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        Year: 
        <select class="form-control" id="lineYear">
          @foreach($years as $value)
            <option value="{{ $value->year }}">{{ $value->year }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        Action: <br>
        <button type="button" class="btn btn-primary" onclick="reload()">Reload</button>
        <button type="button" class="btn btn-info" onclick="reset()">Reset</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"><center>ACC Rej Ratio (% by Pallet)</center><canvas class="chart" id="palletLine" height="150"></canvas></div>
      <div class="col-md-6"><center>ACC Rej Ratio (% by M/C)</center><canvas class="chart" id="machineLine" height="150"></canvas></div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2">
        Model: 
        <select class="form-control" id="top5ModelId">
          <option value="all">All</option>
          @foreach($models as $value)
            <option value="{{ $value->i_models_id }}">{{ $value->n_models_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        From: 
        <input type="date" class="form-control" id="top5DateFrom">
      </div>
      <div class="col-md-2">
        To: 
        <input type="date"class="form-control" id="top5DateTo">
      </div>
      <div class="col-md-2">
        Action: <br>
        <button type="button" class="btn btn-primary" onclick="reload()">Reload</button>
        <button type="button" class="btn btn-info" onclick="reset()">Reset</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"><center>Top 5 Errorcode</center><canvas class="chart" id="topErrorcodeBar" height="150"></canvas></div>
      <div class="col-md-6">
        <div class="table-responsive">
          <table class="table table-bordered" id="topErrorcodeTable">
            <thead>
              <tr>
                <th>Errorcode</th>
                <th>Detail</th>
                <th>Qty</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topErrorcodeData as $val)
                <tr>
                  <td>{{ $val->c_code }}</td>
                  <td>{{ $val->n_errorcode }}</td>
                  <td>{{ $val->qty }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-2">
        <button type="button" class="btn btn-success btn-block" onclick="gotoTop()">To top</button>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/datatables.min.js') }}"></script>
  <script src="{{ asset('js/chart.min.js') }}"></script>
  <script src="{{ asset('js/chartjs-plugin-datalabels.js') }}"></script>
  <script type="text/javascript">
    Chart.plugins.unregister(ChartDataLabels);
    var ctx1 = document.getElementById('palletBar').getContext('2d');
    var palletBar = new Chart(ctx1, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Total Pallet',
              data: [
                @foreach($palletBarTotal as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Rework Pallet',
              data: [
                @foreach($palletBarReject as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          plugins: {
            datalabels: {
              display: !0,
              anchor: 'end',
              align: 'end',
              offset: 0,
              font: {
                style: 'bold'
              }
            }
          },
        }
    });

    var ctx2 = document.getElementById('machineBar').getContext('2d');
    var machineBar = new Chart(ctx2, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Total M/C',
              data: [
                @foreach($machineBarTotal as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Reject M/C',
              data: [
                @foreach($machineBarFail as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          plugins: {
            datalabels: {
              display: !0,
              anchor: 'end',
              align: 'end',
              offset: 0,
              font: {
                style: 'bold'
              }
            }
          },
        }
    });

    var ctx3 = document.getElementById('palletLine').getContext('2d');
    var palletLine = new Chart(ctx3, {
        type: 'line',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Accumulative',
              data: [
                @foreach($palletLineBlue as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Ratio by Pallet',
              data: [
                @foreach($palletLineRed as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          plugins: {
            datalabels: {
              display: !0,
              anchor: 'end',
              align: 'end',
              offset: 0,
              font: {
                style: 'bold'
              }
            }
          },
        }
    });

    var ctx4 = document.getElementById('machineLine').getContext('2d');
    var machineLine = new Chart(ctx4, {
        type: 'line',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Accumulative',
              data: [
                @foreach($machineLineBlue as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Ratio by M/C',
              data: [
                @foreach($machineLineRed as $val)
                  {{ $val }},
                @endforeach
              ],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          plugins: {
            datalabels: {
              display: !0,
              anchor: 'end',
              align: 'end',
              offset: 0,
              font: {
                style: 'bold'
              }
            }
          },
        }
    });

    var ctx5 = document.getElementById('topErrorcodeBar').getContext('2d');
    var topErrorcodeBar = new Chart(ctx5, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: [
            @foreach($top5ErrorcodeBarLabels as $val)
              '{{ $val }}',
            @endforeach
          ],
          datasets: [{
            label: 'Top 5 Errorcode',
            data: [
              @foreach($top5ErrorcodeBarData as $val)
                {{ $val }},
              @endforeach
            ],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          plugins: {
            datalabels: {
              display: !0,
              anchor: 'end',
              align: 'end',
              offset: 0,
              font: {
                style: 'bold'
              }
            }
          },
        }
    });

    var datatable = $('#topErrorcodeTable').DataTable({
      sorting: [[2, 'desc']],
      lengthMenu: [5, 10, 50, 100],
      aoColumns: [
         { mData: 'code' },
         { mData: 'detail' },
         { mData: 'qty' }
      ]
    });

    var processing = false;

    function reload() {
      processing = true;

      var barModelId = $('#barModelId').val();
      var barDateFrom = $('#barDateFrom').val();
      var barDateTo = $('#barDateTo').val();
      var lineModelId = $('#lineModelId').val();
      var lineYear = $('#lineYear').val();
      var top5ModelId = $('#top5ModelId').val();
      var top5DateFrom = $('#top5DateFrom').val();
      var top5DateTo = $('#top5DateTo').val();

      $.get('{{ route("getChartData") }}', {
        barModelId: barModelId,
        barDateFrom: barDateFrom,
        barDateTo: barDateTo,
        lineModelId: lineModelId,
        lineYear: lineYear,
        top5ModelId: top5ModelId,
        top5DateFrom: top5DateFrom,
        top5DateTo: top5DateTo
      })
      .done((response) => {
        var data = JSON.parse(response);

        $('#totalQty').text(data.totalQtyData);

        palletBar.data.datasets[0].data = data.palletBar.palletBarTotal;
        palletBar.data.datasets[1].data = data.palletBar.palletBarReject;
        palletBar.update();

        machineBar.data.datasets[0].data = data.machineBar.machineBarTotal;
        machineBar.data.datasets[1].data = data.machineBar.machineBarFail;
        machineBar.update();

        palletLine.data.datasets[0].data = data.palletLine.palletLineBlue;
        palletLine.data.datasets[1].data = data.palletLine.palletLineRed;
        palletLine.update();

        machineLine.data.datasets[0].data = data.machineLine.machineLineBlue;
        machineLine.data.datasets[1].data = data.machineLine.machineLineRed;
        machineLine.update();

        topErrorcodeBar.data.labels = data.topErrorcode.top5ErrorcodeBarLabels;
        topErrorcodeBar.data.datasets[0].data = data.topErrorcode.top5ErrorcodeBarData;
        topErrorcodeBar.update();

        datatable.clear();
        data.topErrorcode.topErrorcodeData.forEach((errorcode) => {
          datatable.row.add({
            'code': errorcode.c_code,
            'detail': errorcode.n_errorcode,
            'qty': errorcode.qty
          });
        });
        datatable.draw();

        processing = false;
      })
      .fail((error) => {
        processing = false;
      });
    }

    function reset() {
      window.location.reload();
    }

    function onChangeModel(id) {
      var value = $('#' + id).val();
      switch (id) {
        case 'barModelId':
          $('#lineModelId').val(value);
          break;
        case 'lineModelId':
          $('#barModelId').val(value);
          break;
      }
    }

    function gotoTop() {
      $('html, body').animate({ scrollTop: 0 }, 'slow');
    }
  </script>
@endsection