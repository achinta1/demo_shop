<div class="custom-modal-container-sec">
    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?php echo isset($data['heading']) ? trim($data['heading']) : "Add";?></h4>
    </div>
    <div class="modal-body" id="ModalBodySec">
      <button class="btn btn-outline btn-lg btn-block" type="button" id="ModalNotify" style="display:none;"></button>
      <div class="modal-form-section">
        <div class="row">
						<div class="col-md-7 col-md-offset-2">
								{!! Form::open(array('url' => 'admin/brand-edit/'.$data['brands']->id,'files'=>true,'name'=>'editBrandFrm','id'=>'editBrandFrm','role'=>'form')) !!}
									{!! Form::hidden('id',$data['brands']->id) !!}
									<div class="form-group">
										{!! Form::label('brand_name','Brand Name',['class'=>'control-label']) !!}
										{!! Form::text('brand_name', isset($data['brands']->name)?$data['brands']->name:old('brand_name'), ['class'=>'form-control required', 'placeholder'=>'Enter Brand Name',
										'id'=>'BrandName',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('order_position','Order Position',['class'=>'control-label']) !!}
										{!! Form::text('order_position',isset($data['brands']->order_position)?$data['brands']->order_position:old('order_position'), ['class'=>'form-control required', 'placeholder'=>'Enter Order Position',
										'id'=>'OrderPosition',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										<img src="{{URL::to('public/uploads/images/thumb/'.$data['brands']->image) }}"  width="25%" height="100px" alt="">
									</div>
									<div class="form-group">
										{!! Form::label('image','Brand Logo',['class'=>'control-label']) !!}
										{!! Form::file('brand_logo',['class'=>'form-control','id'=>'Image','autofocus'])!!}
									</div>
									<div class="form-group">
										{!! Form::button('Save',['class'=>'btn btn-primary btn-bg-change','type'=>'submit']) !!}
										
									</div>
								{!! Form::close() !!}
						</div>
        </div>						
      </div>
    </div>
</div>
<script>
$(document).ready(function(){
	$("#editBrandFrm").validate({
		rules: {
			'brand_name':{'letterWithSpclChar':$('#BrandName').val(),'minlength':'3','maxlength':'60'},
			'order_position':{'digits':$("#OrderPosition").val(),'range':['1','99999']},
			'brand_logo':{'accept':'jpg,jpeg,png','maxFileSize':['5','MB'],'minFileSize':['50','KB']}
		},
		submitHandler:function(form){
			$('button').prop('disabled',true);
			$.post('<?php echo url('/admin/brandname-exists/'.$data['brands']->id); ?>',{"_token":$('meta[name="csrf-token"]').attr('content'),'brand_name':$('#BrandName').val()},function(rtn_data) {
				var rtn_data_arr=JSON.parse(rtn_data);
				if(rtn_data_arr.status!==undefined && rtn_data_arr.status===false){
					$('#BrandNameERROR').remove();
					$('#BrandName').after('<label for="Code" generated="true" class="error" id="BrandNameERROR">'+rtn_data_arr.msg+'</label>');
					$('button').prop('disabled',false);
				}else{
					form.submit();
				}
			});
    }
  });
});
</script>