
@if(session()->get('n_member'))
  <!DOCTYPE html>
  <html>
  <head>
    <title>@yield('title',env('APP_NAME'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

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
          <li class="nav-item {{ url()->current() == route('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item {{ url()->current() == route('series') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('series') }}">Series</a>
          </li>
          <li class="nav-item {{ url()->current() == route('partName') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('partName') }}" >Part Name</a>
          </li>
          <li class="nav-item {{ url()->current() == route('errorcode') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('errorcode') }}">Errorcode</a>
          </li>
          <!-- <li class="nav-item {{ url()->current() == route('errorcodetype') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('errorcodetype') }}">Errorcode Type</a>
          </li> -->
          <li class="nav-item {{ url()->current() == route('checklist') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('checklist') }}">Checklist</a>
          </li>
          <li class="nav-item {{ url()->current() == route('record') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('record') }}">PPA Inspection Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
        <div class="form-inline text-white my-lg-0">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link">
                {{ session()->get('n_member') }}
              </a>
            </li>
          </ul>
          <a href="{{ route('logout') }}"><button type="button" class="btn btn-danger">Logout</button></a>
        </div>
      </div>
    </nav>
    @yield('content')

    @yield('js')
  </body>
  </html>
@else
  <script>window.location = "{{ route('login') }}";</script>
@endif
