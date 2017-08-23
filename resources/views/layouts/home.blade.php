<html>
	<head>
		<title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

		<style>
      body {
        height: 100%;
        font-family: 'Open Sans'
      }

      .container-table {
        height: 100%;
        display: table;
      }

      .vertical-center-row {
        display: table-cell;
        vertical-align: middle;
      }
		</style>
	</head>
	<body>

    @yield('content')

	</body>
</html>
