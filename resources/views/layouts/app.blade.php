<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="{{asset('img/favicon-btc.png')}}" />

		<!-- Title -->
		<title>BTCCredit</title>
		
		<!-- *************
			************ Common Css Files *************
			************ -->
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />

		<!-- Master CSS -->
		<link rel="stylesheet" href="{{asset('css/main.css')}}" />
		@yield('styles')

  <style>
  .help-block{
	color:red;
	width:100%;
  }

  </style>
	</head>

	@yield('content')
	@yield('scripts')

</html>
