<div class="custom-modal-container-sec">
    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?php echo isset($data['heading']) ? trim($data['heading']) : "Edit";?></h4>
    </div>
    <div class="modal-body" id="ModalBodySec">
      <button class="btn btn-outline btn-lg btn-block" type="button" id="ModalNotify" style="display:none;"></button>
      <div class="modal-form-section">
        <div class="row">
						<div class="col-md-7 col-md-offset-2">
								{!! Form::open(array('url' => 'admin/product-edit/'.$data['products']->id,'files'=>true,'name'=>'editProductFrm','id'=>'editProductFrm','role'=>'form')) !!}
								
									<div class="form-group">
										{!! Form::label('category','Select Category',['class'=>'control-label']) !!}
										{!! Form::select('category',(['' => 'Please Select']+$data['category_list']),old('category')?old('category'):$data['products']->productCategoryMap->cat_id, ['class'=>'form-control required','id'=>'category','autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('sub_category','Select Sub Category',['class'=>'control-label']) !!}
										{!! Form::select('sub_category',(['' => 'Please Select']),null, ['class'=>'form-control required','id'=>'subCategory',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('brand','Select Brand',['class'=>'control-label']) !!}
										{!! Form::select('brand',(['' => 'Please Select']+$data['brand_list']),old('brand')?old('brand'):$data['products']->productBrandMap->brand_id, ['class'=>'form-control','id'=>'brand',										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('name','Product Name',['class'=>'control-label']) !!}
										{!! Form::text('name', old('name')?old('name'):$data['products']->name, ['class'=>'form-control required', 'placeholder'=>'Enter Product Name',
										'id'=>'Name',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('code','Product Code',['class'=>'control-label']) !!}
										{!! Form::text('code', old('code')?old('code'):$data['products']->code, ['class'=>'form-control required', 'placeholder'=>'Enter Product Code',
										'id'=>'Code',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('short_description','Short Description',['class'=>'control-label']) !!}
										{!! Form::textarea('short_description', old('short_description')?old('short_description'):$data['products']->s_description, ['class'=>'form-control required', 'placeholder'=>'Enter Short Description',
										'id'=>'shortDescription',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('long_description','Long Description',['class'=>'control-label']) !!}
										{!! Form::textarea('long_description', old('long_description')?old('long_description'):$data['products']->description, ['class'=>'form-control required', 'placeholder'=>'Enter Long Description',
										'id'=>'longDescription',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('is_featured','Featured',['class'=>'control-label']) !!}
										{!! Form::select('is_featured',[''=>'Select','Y'=>'Yes','N'=>'No'], old('is_featured')?old('is_featured'):$data['products']->is_featured, ['class' => 'form-control']) !!}
									</div>
									<div class="form-group">
										{!! Form::label('price','Price',['class'=>'control-label']) !!}
										{!! Form::text('price', old('price')?number_format(old('price'), 2, '.', ','):number_format($data['products']->productPrice->original_price, 2, '.', ','), ['class'=>'form-control required', 'placeholder'=>'Enter Product Price',
										'id'=>'price',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('discount_percent','Discount Pencentage',['class'=>'control-label']) !!}
										{!! Form::text('discount_percent',										old('discount_percent')?number_format(old('discount_percent'), 2, '.', ','):number_format($data['products']->productPrice->offer_percent, 2, '.', ','),										['class'=>'form-control', 'placeholder'=>'Enter Discount Pencentage','id'=>'discountPercent','autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('discount_start_date','Discount Start Date',['class'=>'control-label']) !!}
										{!! Form::text('discount_start_date', 										old('discount_start_date')?old('discount_start_date'):$data['products']->productPrice->offer_start_date,['class'=>'form-control', 'placeholder'=>'Enter Discount Start Date',
										'id'=>'discountStartDate','autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('discount_end_date','Discount  End date',['class'=>'control-label']) !!}
										{!! Form::text('discount_end_date', old('discount_end_date')?old('discount_end_date'):$data['products']->productPrice->offer_end_date,['class'=>'form-control', 'placeholder'=>'Enter Discount End Date','id'=>'discountEndDate',	'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('vat_percent','Vat Pencentage',['class'=>'control-label']) !!}
										{!! Form::text('vat_percent',old('vat_percent')?number_format(old('vat_percent'), 2, '.', ','):number_format($data['products']->productPrice->vat_percent, 2, '.', ','),['class'=>'form-control required', 'placeholder'=>'Enter Vat Pencentage','id'=>'vatPercent','autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('tax_percent','Tax Pencentage',['class'=>'control-label']) !!}
										{!! Form::text('tax_percent',old('tax_percent')?number_format(old('tax_percent'), 2 , '.', ','):number_format($data['products']->productPrice->tax_percent, 2, '.', ','),['class'=>'form-control required', 'placeholder'=>'Enter Tax Pencentage',
										'id'=>'taxPercent','autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('other_service_charge','Other Service Charge',['class'=>'control-label']) !!}
										{!! Form::text('other_service_charge', old('other_service_charge')?number_format(old('other_service_charge'), 2, '.', ','):number_format($data['products']->productPrice->other_service_charge, 2, '.', ','),['class'=>'form-control required', 'placeholder'=>'Enter Other Service Charge',
										'id'=>'otherServiceCharge',
										'autofocus']) 
										!!}
									</div>
									<div class="form-group">
										{!! Form::label('delevery_charge','Delevery Charge',['class'=>'control-label']) !!}
										{!! Form::text('delevery_charge',old('delevery_charge')?number_format(old('delevery_charge'),2, '.', ','):number_format($data['products']->productPrice->delevery_charge, 2, '.', ','),['class'=>'form-control required', 'placeholder'=>'Enter Delevery Charge',
										'id'=>'deleveryCharge',
										'autofocus']) 
										!!}
									</div>
									
									<div class="form-group">
										{!! Form::label('default_image','Default Image',['class'=>'control-label']) !!}
										{!! Form::file('default_image',['class'=>'form-control ','id'=>'defaultImage','autofocus'])!!}
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
	<?php if(isset($data['products']->productCategoryMap->cat_id) && trim($data['products']->productCategoryMap->cat_id)>0){?>
	subcat_list('<?php echo $data['products']->productCategoryMap->cat_id;?>');
	<?php }?>
	$("#category").on('change',function(){
		var cat_id=$(this).val();
		subcat_list(cat_id);
	});
	function subcat_list(cat_id){
		console.log(cat_id);
		if(cat_id!==undefined && cat_id!="" && cat_id!=null){
			$("#subCategory").empty();
			$("#subCategory").append('<option value="">Select</option>');
			$.post('<?php echo url('/admin/sub-cat-list')?>',{"_token":$('meta[name="csrf-token"]').attr('content'),'id':cat_id},function(rtn_data){
				var rtn_data_arr=JSON.parse(rtn_data);
				var selected_id='<?php echo $data['products']->productCategoryMap->sub_cat_id;?>';
				if(rtn_data_arr!==undefined && rtn_data_arr!=null){
					if(rtn_data_arr.axajdata!==undefined && rtn_data_arr.axajdata!=null){
						$.each(rtn_data_arr.axajdata,function(key,val){
							var selected="";
							if(selected_id==key){
								selected='selected="selected"';
							}
							$("#subCategory").append('<option value="'+key+'" '+selected+'>'+val+'</option>');
						});
					}
				}
			});
		}
	}
	$("#editProductFrm").validate({
		rules: {
			'name':{'minlength':'3','maxlength':'60'},
			'default_image':{'accept':'jpg,jpeg,png','maxFileSize':['5','MB'],'minFileSize':['50','KB']},
			'price':{decimal:$("#price").val()},
			'discount_percent':{decimal:$("#discountPercent").val()},
			'vat_percent':{decimal:$("#vatPercent").val()},
			'tax_percent':{decimal:$("#taxPercent").val()},
			'other_service_charge':{decimal:$("#otherServiceCharge").val()},
			'delevery_charge':{decimal:$("#deleveryCharge").val()},
		},
		submitHandler:function(form){
			$('button').prop('disabled',true);
			$.post('<?php echo url('/admin/product-code-exists/'.$data['products']->id); ?>',{"_token":$('meta[name="csrf-token"]').attr('content'),'code':$('#Code').val(),'id':'<?php echo  $data['products']->id; ?>'},function(rtn_data) {
				var rtn_data_arr=JSON.parse(rtn_data);
				if(rtn_data_arr.status!==undefined && rtn_data_arr.status===false){
					$('#ProductCodeERROR').remove();
					$('#Code').after('<label for="Code" generated="true" class="error" id="ProductCodeERROR">'+rtn_data_arr.msg+'</label>');
					$('button').prop('disabled',false);
				}else{
					form.submit();
				}
			});
    }
	});
});
</script>