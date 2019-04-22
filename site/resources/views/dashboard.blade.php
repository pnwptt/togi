@extends('layouts.master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/chart.min.css') }}">
  <style type="text/css">
    table {
      border-radius: 0;
      padding: 0;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-3">
        Model: 
        <select class="form-control">
          @foreach($models as $value)
            <option value="{{ $value->i_models_id }}">{{ $value->n_models_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-3">
        From: 
        <input type="date" class="form-control" name="" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-sm-3">
        To: 
        <input type="date"class="form-control" name="" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-sm-1">
        Action: 
        <button type="button" class="btn btn-primary btn-block">Reload</button>
      </div>
      <div class="col-sm-1"></div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6"><canvas id="myChart1" height="150"></canvas></div>
      <div class="col-md-6"><canvas id="myChart2" height="150"></canvas></div>
      <div class="col-md-12"><hr></div>
      <div class="col-md-6"><canvas id="myChart3" height="150"></canvas></div>
      <div class="col-md-6"><canvas id="myChart4" height="150"></canvas></div>
      <div class="col-md-12"><hr></div>
      <div class="col-md-6"><canvas id="myChart5" height="150"></canvas></div>
      <div class="col-md-6">
        <div class="table-responsive">
          <table class="table table-bordered" id="datatables">
            <thead>
              <tr>
                <th>Errorcode</th>
                <th>Detail</th>
                <th>Qty</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Code1</td>
                <td>test</td>
                <td>55</td>
              </tr>
              <tr>
                <td>Code2</td>
                <td>test</td>
                <td>46</td>
              </tr>
              <tr>
                <td>Code3</td>
                <td>test</td>
                <td>73</td>
              </tr>
              <tr>
                <td>Code4</td>
                <td>test</td>
                <td>16</td>
              </tr>
              <tr>
                <td>Code5</td>
                <td>test</td>
                <td>64</td>
              </tr>
              <tr>
                <td>Code6</td>
                <td>test</td>
                <td>28</td>
              </tr>
              <tr>
                <td>Code7</td>
                <td>test</td>
                <td>38</td>
              </tr>
              <tr>
                <td>Code8</td>
                <td>test</td>
                <td>54</td>
              </tr>
              <tr>
                <td>Code9</td>
                <td>test</td>
                <td>67</td>
              </tr>
            </tbody>
          </table>
        </div>
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
    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Total Pallet',
              data: [12, 19, 13, 15, 12, 13, 16, 19, 13, 15, 14, 11],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Fail',
              data: [3, 6, 2, 2, 3, 4, 3, 5, 1, 2, 3, 1],
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

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
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

    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Total M/C',
              data: [12, 19, 13, 15, 12, 13, 16, 19, 13, 15, 14, 11],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            },
            {
              label: 'Fail',
              data: [3, 6, 2, 2, 3, 4, 3, 5, 1, 2, 3, 1],
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

    var ctx4 = document.getElementById('myChart4').getContext('2d');
    var myChart4 = new Chart(ctx4, {
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

    var ctx5 = document.getElementById('myChart5').getContext('2d');
    var myChart5 = new Chart(ctx5, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
          labels: ['Errorcode1', 'Errorcode2', 'Errorcode3', 'Errorcode4', 'Errorcode5'],
          datasets: [{
            label: 'Top 5 Errorcode',
            data: [73, 67, 64, 55, 54],
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

    $('#datatables').DataTable({
      sorting: [[2, 'desc']],
      lengthMenu: [5, 25, 50, 100]
    });
  </script>
@endsection