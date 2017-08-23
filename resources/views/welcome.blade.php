<html>
	<head>
		<title>Loyalty Program</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		<style>
			.header {
				background-color: #2DC3D1;
				padding-top: 75px;
				padding-bottom: 120px;
				margin-bottom: 0px;
			}

			.header > .title {
				font-family: 'Lato', sans-serif;
				font-weight: 300;
				color: #FFFFFF;
			}

			.header > .content {
				font-family: 'Open Sans', sans-serif;
				font-weight: 300;
				color: #FFFFFF;
			}

			.header > .margin {
				margin-top: 10px;
			}

			.header > * > .form-horizontal > .btn-padding {
				padding-top: 10px;
				padding-bottom: 10px;
			}

			.header > * > .form-horizontal > .btn-custom {
				background: #2DC3D1;
				color: #FFFFFF;
				font-family: 'Open Sans';
				font-size: 20px;
				font-weight: 400;
				border: 1px solid white;
			}

			.header > * > .form-horizontal > .btn-custom:hover {
				background: #FFFFFF;
				color: #2DC3D1;
				border: 1px solid #33D5AD;
			}

			.about > .container > .title {
				font-family: 'Open Sans';
				font-weight: 400;
				color: #525252;
			}

			.about > .container > * > .content {
				font-family: 'Open Sans';
				font-weight: 400;
				font-size: 18px;
				color: #525252;
			}

			.custom-bg {
				background: #F0F2F1;
			}

			.custom-padding {
				padding-top: 50px;
				padding-bottom: 30px;
			}

			.customize {

			}

			.title {
				font-family: 'Lato', sans-serif;
				font-weight: 300;
			}

			.content {
				font-family: 'Open Sans';
				font-weight: 400;
				font-size: 18px;
			}

			.thumbnail-margin {
				margin-top: 30px;
			}
		</style>
	</head>
	<body>
		<!-- header -->
		<div class="jumbotron text-center header">
			<h1 class="title">LOYALTY PROGRAM</h1>
			<h3 class="content">Make the customer the hero of your story. – Ann Handley</h3>
			<br>
			<div class="col-sm-2 col-sm-offset-4 col-md-2 col-md-offset-4 margin">
				<form class="form-horizontal" role="form" action="{{ url('/login') }}" method="get">
					<button type="submit" class="btn btn-default btn-block btn-padding btn-custom">LOGIN</button>
				</form>
			</div>
			<div class="col-sm-2 col-md-2 margin">
				<form class="form-horizontal" role="form" action="{{ url('/signup') }}" method="get">
					<button type="submit" class="btn btn-default btn-block btn-padding btn-custom">SIGN UP</button>
				</form>
			</div>
		</div>

		<!-- about -->
		<div class="container-fluid text-center custom-padding">
			some content here
		</div>

	</body>
</html>
