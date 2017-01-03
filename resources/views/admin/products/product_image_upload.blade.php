<script src="{{ asset('public/dropzone/js/dropzone.js')}}"></script>
<link href="{{ asset('public/dropzone/css/dropzone.css')}}" rel="stylesheet">
<div class="custom-modal-container-sec">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo isset($data['heading']) ? trim($data['heading']) : "Add";?></h4>
    </div>
    <div class="modal-body" id="ModalBodySec">
        <button class="btn btn-outline btn-lg btn-block" type="button" id="ModalNotify" style="display:none;"></button>
        <div class="modal-form-section">					
					{{ Form::open(array('url' => "#", 'method' => 'post', 'files' => true,'class'=>"form-horizontal", 'id'=>"add-product-image")) }}
					<p>Upload <strong>Product</strong> image (jpg,png or jpeg)</p><div id="productMultiImageUpload" class="dropzone"></div>
					{{ Form:: close() }}
					
					<?php 
						if(isset($data['product_images'])){
							echo '<div class="row multi-image-cont">';
							foreach($data['product_images'] as $values){
					?>
						<div class="col-md-4 col-xs-6 thumb" id="MmultiImageSec_<?php echo $values->id?>">
							<a class="thumbnail thumb_fixed_height " href="javascript:void(0)">
								<img src="{{URL::to('public/uploads/images/thumb/'.$values->image) }}"  width="25%" height="100px" alt="" class="img-responsive">
								
								
								<span href="javascript:void(0)" data-href="{{ url('/admin/ajax-dropzone-product-img-remove/'.$values->id) }}" data-id="<?php echo $values->id;?>", class="deleteMmultiImageSec delete_img" ><i style="color:#FF0000" title="Click to Delete" class="fa fa-times-circle fa-lg" aria-hidden="true"></i></span>
								
								<span href="javascript:void(0)" data-href="{{ url('/admin/ajax-dropzone-product-img-change-status/'.$values->id) }}" data-id="<?php echo $values->id;?>", class="changeMmultiImageSec image_default_status default_image" id="ChangeMmultiImageSecStatus_<?php echo $values->id;?>" data-status="<?php echo $values->status;?>">
								<?php if(trim($values->status)=='ACTIVE'){?>
								<i style="color:#439f43" title="Click to Inactive" class="fa fa-check-square fa-lg" aria-hidden="true"></i>
								<?php } else {?>
								<i style="color:#FF0000" title="Click to Active" class="fa fa-check-square fa-lg" aria-hidden="true"></i>
								<?php } ?>
								</span>
							</a>
						</div>
					<?php 
						} 
						echo '</div>';
					}
					?>
        </div>
    </div>
</div>
<script>

$(document).ready(function(){
		var remove_url="<?php echo url('/admin/ajax-dropzone-product-img-remove/')?>";
		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone("div#productMultiImageUpload", {
		url: "<?php echo url('/admin/ajax-dropzone-product-img-upload/'.$data['p_id'])?>",
		maxFilesize: 10,
		paramName: "product_image",
		acceptedFiles: ".png,.jpg,jpeg",
		addRemoveLinks: true,
		headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
		removedfile: function(file) {
			var remove_link= $(file.previewTemplate).children(".dz-remove").attr("href");
			console.log("==1=>>"+remove_link);
			if(typeof remove_link!=undefined && remove_link.trim()!=""){
				setTimeout(function(){
				 $.ajax({
					 url:remove_link,
					 data:{'_token':$('meta[name="csrf-token"]').attr('content')},
					 success:function(rtn_data){
						 var rtn_val=$.parseJSON(rtn_data);
						 if(typeof rtn_val.status !=undefined && rtn_val.status.trim()=="success"){
						 }
					 }
				 });
				},100);
				setTimeout(function(){
					var fileRef;
					return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
				},100);
			}
		},
		 success: function(file, response){
			var response_data=$.parseJSON(response);
			if(typeof response_data.status!=undefined && response_data.status.trim()=="SUCCESS"){
				$(file.previewTemplate).children(".dz-remove").attr("data-image_id", response_data.image_id);
				$(file.previewTemplate).children(".dz-remove").attr("href", remove_url+response_data.image_id);
				$(file.previewTemplate).children(".dz-remove").attr("data-dz-remove",remove_url+response_data.image_id);
			}else{
				$(file.previewTemplate).children(".dz-image").css("background", "red");
			 $(file.previewTemplate).children(".dz-remove").css("color", "red");
			}
		 },
		 error: function(file, response){
			 $(file.previewTemplate).children(".dz-image").css("background", "red");
			 $(file.previewTemplate).children(".dz-remove").css("color", "red");
		 }
	 });
	 //=======remove image=====
		$('.deleteMmultiImageSec').click(function(){
			var action_link = $(this).data('href');
			console.log("==1=>>"+action_link);
			var id = $(this).data('id');
			var content_id='MmultiImageSec_'+id;
			$(this).parent('a').css({"background":"red","opacity":".4"});
			$(this).remove();
			$("#ChangeMmultiImageSecStatus_"+id).remove();
			if(confirm('Are you sure want to delete?')){
			 $.post(action_link,{"id":id,'_token':$('meta[name="csrf-token"]').attr('content')},function(data_arr){
					var return_data=$.parseJSON(data_arr);
					if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='SUCCESS'){
						$("#"+content_id).remove();
					}
			 });
			}
			
		});
	 //========= change status==========
	 $('.thumbnail').on('click','.changeMmultiImageSec',function(){
			var action_link = $(this).data('href');
			var id = $(this).data('id');
			var content_id= $(this).attr('id');
			if(confirm('Are you sure want to change the status?')){
				$.post(action_link,{"id":id,'_token':$('meta[name="csrf-token"]').attr('content')},function(data_arr){
					var return_data=$.parseJSON(data_arr);
					//console.log(return_data);
					if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='SUCCESS'){
						if(return_data.change_status!==undefined && return_data.change_status!==null && return_data.change_status.trim()==="ACTIVE"){
							$("#"+content_id).html('<i style="color:#439f43" title="Click to Inactive" class="fa fa-check-square fa-lg" aria-hidden="true"></i>');
						}
						if(return_data.change_status!==undefined && return_data.change_status!==null && return_data.change_status.trim()==="INACTIVE"){
							$("#"+content_id).html('<i style="color:#FF0000" title="Click to Active" class="fa fa-check-square fa-lg" aria-hidden="true"></i>');
						}
					}
				});
			}
	 });
});
</script>