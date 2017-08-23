<html>
	<head>
		<title>Loyalty | Signup</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  	<link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset("/bower_components/font-awesome-4.6.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
	</head>
  <body class="hold-transition register-page">
    <div class="register-box">

      <div class="register-logo">
        <b>LOYALTY SYSTEM</b>
      </div>
      @if (Session::has('flash_message'))
        <div class="alert alert-danger">{{ Session::get('flash_message') }}</div>
      @endif

      <div class="register-box-body">
        <p class="login-box-msg">Sign up a new account</p>
        <form action="{{ url('/signup') }}" method="post" >

          <div class="form-group has-feedback{{$errors->has('username') ? ' has-error' : ''}}">
            <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            @if($errors->has('username'))
            <span class="help-block">{{ $errors->first('username') }}</span>
            @endif
          </div>

          <div class="form-group has-feedback{{$errors->has('password') ? ' has-error' : ''}}">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
            @endif
          </div>

          <div class="form-group has-feedback{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password_confirmation'))
              <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
            @endif
          </div>

          <div class="form-group has-feedback{{$errors->has('email') ? ' has-error' : ''}}">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
              <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
          </div>

          <div class="form-group{{$errors->has('owner') ? ' has-error' : ''}}">
            <input type="text" class="form-control" name="owner" value="{{ old('owner') }}" placeholder="Owner Name" required>
            @if ($errors->has('owner'))
              <span class="help-block">{{ $errors->first('owner') }}</span>
            @endif
          </div>

          <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Shop Name" required>
						@if ($errors->has('name'))
							<span class="help-block">{{ $errors->first('name') }}</span>
						@endif
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign Up</button>
          </div>

        </form>

        <a href="{{ url('login') }}" class="text-center">Already have a account</a>

        <br>

      </div>
    </div>


  </body>
</html>
