<!DOCTYPE html>
<html>
<head>
  <title>@yield('title', 'TOGI')</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

  <style type="text/css">
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
    <a class="navbar-brand" href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ url()->current() == route('home') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{ url()->current() == route('series') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('series') }}">Series</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('checklist') }}">Checklist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
      <form class="form-inline my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Username" name="username">
        <input class="form-control mr-sm-2" type="text" placeholder="Password" name="password">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Login</button>
      </form>
    </div>
  </nav>
  @yield('content')

  @yield('js')
</body>
</html>