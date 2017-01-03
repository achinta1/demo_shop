<!-- bootstrap JavaScript -->
<script src="{{asset('public/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- jquery validator -->
<script src="{{asset('public/js/jquery.validate.js')}}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('public/bootstrap/metisMenu/metisMenu.min.js')}}"></script>
<!-- bootstrap admin theme JavaScript -->
<script src="{{asset('public/bootstrap/js/admin_theme.js')}}"></script>
<!-- app JavaScript -->
<script src="{{asset('public/js/common.js')}}"></script>
<!-- DataTables JavaScript -->
<script src="{{asset('public/bootstrap/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

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