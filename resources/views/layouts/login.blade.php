<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ isset($data['meta_title'])?$data['meta_title']:'DemoShop' }}</title>
		<script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>
		<link href="{{ asset('public/admin/images/favicon.ico')}}" type="image/x-icon" rel="shortcut icon" />
		<!-- Bootstrap Core CSS -->
		<link href="{{ asset('public/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="{{ asset('public/admin/css/style.css')}}" rel="stylesheet">
		<!-- jquery JavaScript -->
		<script src="{{ asset('public/jquery/jquery.min.js')}}"></script>
  </head>
	<body>
		@yield('content')
		<div class="copy_site" style="top:220px;background-color:#FFF;">&copy; <?php echo date('Y');?></div>
		<!-- bootstrap JavaScript -->
		<script src="{{ asset('public/bootstrap/js/bootstrap.min.js')}}"></script>
		<!-- jquery validator -->
		<script src="{{ asset('public/js/jquery.validate.js')}}"></script>
	</body>
</html>