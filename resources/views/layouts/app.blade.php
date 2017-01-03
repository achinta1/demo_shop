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
		<!-- Custom Fonts -->
		<link href="{{ asset('public/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="{{ asset('public/admin/css/style.css')}}" rel="stylesheet">
		<!-- DataTables CSS -->
		<link href="{{ asset('public/bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
		<!-- jquery JavaScript -->
		<script src="{{ asset('public/jquery/jquery.min.js')}}"></script>
    </head>
<body>
<!-----./Modal Pop-Up------->
<div id="ModalPopUpID" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog"><div class="modal-content" id="Modal-Pop-Content"></div></div>
</div>
@include('layouts.admin.leftSidebar')
@yield('content')
<!-- bootstrap JavaScript -->
<script src="{{ asset('public/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- jquery validator -->
<script src="{{ asset('public/js/jquery.validate.js')}}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('public/bootstrap/metisMenu/metisMenu.min.js')}}"></script>
<!-- bootstrap admin theme JavaScript -->
<script src="{{ asset('public/bootstrap/js/admin_theme.js')}}"></script>
<!-- app JavaScript -->
<script src="{{ asset('public/js/common.js')}}"></script>
<!-- DataTables JavaScript -->
<script src="{{ asset('public/bootstrap/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

<div class="copy_site" style="top:220px;background-color:#FFF;">&copy; <?php echo date('Y');?></div>

<!-- script Modal pop -->
<script>
	$("body").on("click",'.Modal-Pop-Link-Apr', function(){
		var action_link = $(this).data('href');
		//$('#ModalPopUpID').modal({backdrop: 'static',keyboard: true, show: true});
		$('#Modal-Pop-Content').attr('style','margin-top:113px !important;');
		$("#Modal-Pop-Content").html('<div style="text-align: center;text-align: center;font-size: 20px;font-weight: bold;margin-top: 70px; margin-bottom:40px;"><img src="<?php echo asset('public/admin/images/loading-loader_m.gif');?>"></div>');
		$.get(action_link,function(return_data){
            $('#Modal-Pop-Content').attr('style','margin-top:70px !important;');
			$("#Modal-Pop-Content").html(return_data);
		});
	});
</script>
</body>
</html>