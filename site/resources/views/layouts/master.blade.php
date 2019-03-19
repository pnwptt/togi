
@if(session()->get('c_user'))
  <!DOCTYPE html>
  <html>
  <head>
    <title>@yield('title',env('APP_NAME'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.min.css') }}">

    <style type="text/css">
    table {
      padding: 15px; 
      -moz-border-radius: 15px; 
      -khtml-border-radius: 15px; 
      -webkit-border-radius: 15px; 
      border-radius: 15px;
    }
    table th {
      text-align: center;
    }
    nav {
      margin-bottom: 25px;
    }
  </style>

  @yield('css')
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
          @if(session()->get('admin'))
          <li class="nav-item {{ url()->current() == route('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="management" aria-expanded="false">
              Management <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="management">
              <a class="dropdown-item" href="{{ route('models') }}">Model / Serie</a>
              <!-- <a class="dropdown-item" href="{{ route('errorcodetype') }}">Errorcode Type</a> -->
              <a class="dropdown-item" href="{{ route('errorcode') }}">Errorcode</a>
              <a class="dropdown-item" href="{{ route('checklist') }}">Checklist</a>
            </div>
          </li>
          @endif
          <li class="nav-item {{ url()->current() == route('record') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('record') }}">PPA Inspection Report</a>
          </li>
        </ul>
        <div class="form-inline text-white my-lg-0">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link">
                {{ session()->get('c_user') }}
              </a>
            </li>
          </ul>
          <a href="{{ route('logout') }}"><button type="button" class="btn btn-danger">Logout</button></a>
        </div>
      </div>
    </nav>
    @yield('content')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('js')
  </body>
  </html>
@else
  <script>window.location = "{{ route('login') }}";</script>
@endif
