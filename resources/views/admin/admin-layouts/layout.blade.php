<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="img/fav.png" />
    	<meta name="csrf-token" content="{{ csrf_token() }}" />

		<!-- Title -->
		<title>Retail Admin Template - Dashboard</title>



		<!-- *************
			************ Common Css Files *************
			************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
		
		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" type="text/css" href="{{ asset('fonts/style.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('css/main.css')}}">


		<!-- *************
			************ Vendor Css Files *************
			************ -->
		<!-- Datepickers css -->
		<link rel="stylesheet" href="{{ asset('vendor/daterange/daterange.css')}}" />
		@yield('styles')

	</head>
	<body>

		<!-- Loading starts -->
		<div id="loading-wrapper">
			<div class="spinner-border text-apex-green" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<!-- Loading ends -->



        @yield('content')

        @yield('scripts')


	</body>
</html>