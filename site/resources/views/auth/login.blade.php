<!DOCTYPE html>
<html>
<head>
  <title>@yield('title',env('APP_NAME'))</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

  <style type="text/css">
    nav {
      margin-bottom: 15vh;
    }

    .error-message {
      font-weight: bold;
      color: red;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <div class="card text-white bg-primary">
          <div class="card-header">Authentication</div>
          <div class="card-body">
            @if(session()->has('error'))
              <p class="error-message">{{ session()->get('error') }}</p>
            @endif
            <form action="{{ route('login') }}" method="post" class="form form-horizontal">
              {{ csrf_field() }}
              <div class="form-group">
                <div class="form-group">
                  <label><b>Username</b></label>
                  <input type="text" class="form-control" name="c_user" value="{{ old('c_user') }}" required autofocus>
                </div>
                <div class="form-group">
                  <label><b>Password</b></label>
                  <input type="password" class="form-control" name="c_password" required>
                </div>
                <div class="form-group" align="center">
                  <button type="submit" class="btn btn-success">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>