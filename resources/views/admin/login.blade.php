<html>
	<head>
		<title>Admin | Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  	<link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset("/bower_components/font-awesome-4.6.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>LOYALTY ADMIN</b>
			</div>
			@if (Session::has('error_message'))
				<div class="alert alert-danger">{{ Session::get('error_message') }}</div>
			@endif
			<div class="login-box-body">
				<br>
				<form action="{{ URL::current() }}" method="post">
					<div class="form-group has-feedback">
	          			<input type="text" class="form-control" name="username" value="{{ old('username') }}"placeholder="Username" required>
	          			<span class="glyphicon glyphicon-user form-control-feedback"></span>
	        		</div>
	        		<div class="form-group has-feedback">
	          			<input type="password" class="form-control" name="password" placeholder="Password" required>
	          			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	        		</div>
	        		<div class="form-group">
	        			<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
	        		</div>
				</form>
			</div>
		</div>
	</body>

</html>
