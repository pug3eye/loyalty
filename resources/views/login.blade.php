<html>
	<head>
		<title>Loyalty | Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  	<link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset("/bower_components/font-awesome-4.6.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>LOYALTY SYSTEM</b>
			</div>
			@if (Session::has('flash_message'))
				<div class="alert alert-success">{{ Session::get('flash_message') }}</div>
			@endif
			@if (Session::has('error_message'))
				<div class="alert alert-danger">{{ Session::get('error_message') }}</div>
			@endif
			<div class="login-box-body">
				<p class="login-box-msg">Please login to start your session</p>

				<form action="{{ url('login') }}" method="post">

					<div class="form-group has-feedback">
          	<input type="text" class="form-control" name="username" placeholder="Username" required>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>

        	</div>
        	<div class="form-group has-feedback">
          	<input type="password" class="form-control" name="password" placeholder="Password" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
        	</div>

					<div class="row">
            <div class="col-xs-8">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember"> Remember Me
                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div>
          </div>
				</form>
				<a href="{{ url('signup') }}" class="text-center">Register a new account</a>
				<br>
			</div>
		</div>
	</body>
</html>
