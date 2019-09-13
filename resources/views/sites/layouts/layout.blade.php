<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Holipic">
    <meta name="keywords" content="Holipic">
    <meta name="author" content="Danh Le Thanh">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="images/HOLIPIC-FAVICON.png" />

	<!-- Page Title -->
	<title>@yield('title')</title>

    <!-- Google Fonts css-->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900%7CRubik:300,400,500,700,900" rel="stylesheet">

	@include('sites.partials.styles')

    @yield('styles')

</head>
<body data-spy="scroll" data-target="#navigation" data-offset="71">

	<!-- Preloader starts -->
	<div class="preloader">
		<div class="loader">
			<div class="diamond"></div>
			<div class="diamond"></div>
			<div class="diamond"></div>
		</div>
	</div>
	<!-- Preloader Ends -->
	@include('sites.partials.header')

	@yield('content')




	{{-- @include('sites.partials.banner-intro') --}}

	<!-- Pricing section starts -->

	<!-- Mega Footer section starts -->
	@include('sites.partials.footer')

	<!-- Footer section ends -->

	@include('sites.partials.scripts')
	@yield('scripts')
</body>
</html>
