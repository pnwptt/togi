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
      <div class="col-sm-1"></div>
      <div class="col-sm-2">
        Model: 
        <select class="form-control" id="i_models_id">
          <option value="all">All</option>
          @foreach($models as $value)
            <option value="{{ $value->i_models_id }}">{{ $value->n_models_name }}</option>
          @endforeach
        </select>
      </div>
      <!-- <div class="col-sm-2"></div> -->
      <div class="col-sm-2">
        Group by: 
        <select class="form-control" id="grouping">
          <option value="week">Week</option>
          <option value="month" selected>Month</option>
        </select>
      </div>
      <div class="col-sm-2">
        From: 
        <input type="date" class="form-control" id="dateFrom">
      </div>
      <div class="col-sm-2">
        To: 
        <input type="date"class="form-control" id="dateTo">
      </div>
      <div class="col-sm-2">
        Action: <br>
        <button type="button" class="btn btn-primary" onclick="reload()">Reload</button>
        <button type="button" class="btn btn-info" onclick="reset()">Reset</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"><canvas class="chart" id="palletBar" height="150"></canvas></div>
      <div class="col-md-6"><canvas class="chart" id="palletLine" height="150"></canvas></div>
      <div class="col-md-6"><canvas class="chart" id="machineBar" height="150"></canvas></div>
      <div class="col-md-6"><canvas class="chart" id="machineLine" height="150"></canvas></div>
      <div class="col-md-6"><canvas class="chart" id="topErrorcodeBar" height="150"></canvas></div>
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
    <div class="row">
      <div class="col-sm-2">
        <button type="button" class="btn btn-success" onclick="gotoTop()">To top</button>
        <button type="button" class="btn btn-primary" onclick="reload()">Reload</button>
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
              label: 'Total Reject',
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

    var ctx2 = document.getElementById('palletLine').getContext('2d');
    var palletLine = new Chart(ctx2, {
        type: 'line',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Total Pallet',
              data: [6, 8, 6, 7, 6, 6, 8, 9, 6, 7, 7, 5],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Fail',
              data: [1, 3, 2, 2, 1, 2, 4, 3, 1, 1, 2, 1],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
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

    var ctx3 = document.getElementById('machineBar').getContext('2d');
    var machineBar = new Chart(ctx3, {
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
              label: 'Total Fail',
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
              label: 'Total M/C',
              data: [6, 8, 6, 7, 6, 6, 8, 9, 6, 7, 7, 5],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Fail',
              data: [1, 3, 2, 2, 1, 2, 4, 3, 1, 1, 2, 1],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
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
              @foreach($top5ErrorcodeData as $val)
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

    $('#topErrorcodeTable').DataTable({
      sorting: [[2, 'desc']],
      lengthMenu: [5, 10, 50, 100]
    });

    var processing = false;

    function reload() {
      processing = true;

      var i_models_id = $('#i_models_id').val();
      var grouping = $('#grouping').val();
      var dateFrom = $('#dateFrom').val();
      var dateTo = $('#dateTo').val();

      $.get('{{ route("getChartData") }}', {
        i_models_id: i_models_id,
        grouping: grouping,
        dateFrom: dateFrom,
        dateTo: dateTo
      })
      .done((response) => {
        var data = JSON.parse(response);

        palletBar.data.labels = data.palletBar.palletBarLabels;
        palletBar.data.datasets[0].data = data.palletBar.palletBar1;
        palletBar.data.datasets[1].data = data.palletBar.palletBar2;
        palletBar.update();

        machineBar.data.labels = data.machineBar.machineBarLabels;
        machineBar.data.datasets[0].data = data.machineBar.machineBar1;
        machineBar.data.datasets[1].data = data.machineBar.machineBar2;
        machineBar.update();

        topErrorcodeBar.data.labels = data.topErrorcode.top5ErrorcodeBarLabels;
        topErrorcodeBar.data.datasets[0].data = data.topErrorcode.top5ErrorcodeBarData;
        topErrorcodeBar.update();

        processing = false;
      })
      .fail((error) => {
        processing = false;
      });
    }

    function reset() {
      window.location.reload();
    }

    function gotoTop() {
      $('html, body').animate({ scrollTop: 0 }, 'slow');
    }
  </script>
@endsection