<div class="custom-modal-container-sec">
    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?php echo isset($data['heading']) ? trim($data['heading']) : "Add";?></h4>
    </div>
    <div class="modal-body" id="ModalBodySec">
      <button class="btn btn-outline btn-lg btn-block" type="button" id="ModalNotify" style="display:none;"></button>
      <div class="modal-form-section">
        <div class="row">
					<?php if(isset($data['exceptionError']) && trim($data['exceptionError'])!=""){ ?>
						<div class="col-md-12">
							<div class="alert alert-danger">
								<?php echo $data['exceptionError'];?>
							</div>
						</div>
					<?php }else{?>
						<div class="col-md-7 col-md-offset-2">
								{!! Form::open(array('url' => 'admin/sub-category-edit/'.$data['categories']->id,'files'=>true,'name'=>'editSubCategoryFrm','id'=>'editSubCategoryFrm','role'=>'form')) !!}
									{!! Form::hidden('id',$data['categories']->id) !!}
									
									<div class="form-group">
										{!! Form::label('category','Select Category',['class'=>'control-label']) !!}
										{!! Form::select('category',(['' => 'Please Select']+$data['category_list']),isset($data['categories']->parent_id)?$data['categories']->parent_id:old('category'), ['class'=>'form-control required', 									'id'=>'category',
										'autofocus']) 
										!!}
									</div>
									
									<div class="form-group">
										{!! Form::label('name','Sub Category Name',['class'=>'control-label']) !!}
										{!! Form::text('name', isset($data['categories']->name)?$data['categories']->name:old('name'), ['class'=>'form-control required', 'placeholder'=>'Enter Sub Category Name',
										'id'=>'Name',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										<img src="{{URL::to('public/uploads/images/thumb/'.$data['categories']->image) }}"  width="25%" height="100px" alt="">
									</div>
									<div class="form-group">
										{!! Form::label('image','Sub Category Logo',['class'=>'control-label']) !!}
										{!! Form::file('sub_category_logo',['class'=>'form-control','id'=>'Image','autofocus'])!!}
									</div>
									<div class="form-group">
										{!! Form::button('Save',['class'=>'btn btn-primary btn-bg-change','type'=>'submit']) !!}
										
									</div>
								{!! Form::close() !!}
						</div>
					<?php }?>
        </div>						
      </div>
    </div>
</div>
<script>
$(document).ready(function(){
	<?php if(isset($data['categories']->id)){?>
	$("#editSubCategoryFrm").validate({
		rules: {
			'name':{'letterWithSpclChar':$('#Name').val(),'minlength':'3','maxlength':'60'},
			'category_logo':{'accept':'jpg,jpeg,png','maxFileSize':['5','MB'],'minFileSize':['50','KB']}
		},
		submitHandler:function(form){
			$('button').prop('disabled',true);
			$.post('<?php echo url('/admin/categoryname-exists/'.$data['categories']->id); ?>',{"_token":$('meta[name="csrf-token"]').attr('content'),'name':$('#Name').val()},function(rtn_data) {
				var rtn_data_arr=JSON.parse(rtn_data);
				if(rtn_data_arr.status!==undefined && rtn_data_arr.status===false){
					$('#CategoryNameERROR').remove();
					$('#Name').after('<label for="Code" generated="true" class="error" id="CategoryNameERROR">'+rtn_data_arr.msg+'</label>');
					$('button').prop('disabled',false);
				}else{
					form.submit();
				}
			});
    }
  });
	<?php }?>
});
</script>