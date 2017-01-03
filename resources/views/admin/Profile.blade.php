@extends('../layouts.app')

@section('content')
<div id="wrapper">
      <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header page_title">
							{{ isset($data['heading']) ? trim($data['heading']) : "" }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
							@include('layouts.flash-message')							 
							{!! Form::open(array('url' => 'admin/profile','files'=>true,'name'=>'EditProfileFrm','id'=>'EditProfileFrm','role'=>'form')) !!}
								{!!Form::hidden('id',$data['users']->id)!!}
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								{!! Form::label('name','User Name',['class'=>'control-label']) !!}
								{!! Form::text('name', old('name')?old('name'):$data['users']->name, ['class'=>'form-control required', 'placeholder'=>'Enter User Name',
								'id'=>'name'
								]) !!}
								<span class="text-danger">{{ $errors->first('name') }}</span>
							</div>
              
							<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
								{!! Form::label('email','Email-Id',['class'=>'control-label']) !!}
								{!! Form::text('email', old('email')?old('email'):$data['users']->email, ['class'=>'form-control required email', 'placeholder'=>'Enter Email-Id',
								'id'=>'email'
								]) !!}
								<span class="text-danger">{{ $errors->first('email') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
								{!! Form::label('phone','Phone Number',['class'=>'control-label']) !!}
								{!! Form::text('phone', old('phone')?old('phone'):$data['users']->phone, ['class'=>'form-control required', 'placeholder'=>'Enter Phone Number',
								'id'=>'phone'
								]) !!}
								<span class="text-danger">{{ $errors->first('phone') }}</span>
							</div>							
							<div class="form-group {{ $errors->has('about') ? 'has-error' : '' }}">
								{!! Form::label('about','Small Description',['class'=>'control-label']) !!}
								{!! Form::textarea('about', old('about')?old('about'):$data['users']->about, ['class'=>'form-control', 'placeholder'=>'Enter Small Description',
								'id'=>'about'
								]) !!}
								<span class="text-danger">{{ $errors->first('about') }}</span>
							</div>
							<?php if(isset($data['users']->default_image) && trim($data['users']->default_image)!=""){?>
							<div class="form-group">
								<img src="{{URL::to('public/uploads/images/thumb/'.$data['users']->default_image) }}" class="img-rounded" alt="Cinque Terre" width="90" height="90">
							</div>
							<?php }?>
							<div class="form-group {{ $errors->has('default_image') ? 'has-error' : '' }}">
								{!! Form::file('default_image',['class'=>'form-control','id'=>'default_image'])!!}
								<span class="text-danger">{{ $errors->first('default_image') }}</span>
							</div>
              <div class="form-group">
								{!! Form::button('Save',['class'=>'btn btn-primary btn-bg-change','type'=>'submit']) !!}
              </div>
							{!! Form::close() !!}
          </div>
        </div>
    </div>
  </div>
<script>
$(document).ready(function(){
	$("#EditProfileFrm").validate({
		rules: {
			'username':{'numberLetter':$("#username").val()},
			'phone':{'digits':$('#phone').val(),'minlength':'10','maxlength':'12'},
			'default_image':{'accept':'jpg,jpeg,png','maxFileSize':['5','MB'],'minFileSize':['50','KB']}
		},
		submitHandler:function(form) {
			$('button').prop('disabled',true);
			$.post('<?php echo url('/admin/users-email-exists/'.$data['users']->id)?>',{"_token":$('meta[name="csrf-token"]').attr('content'),'email':$('#email').val(),'id':'<?php echo $data['users']->id;?>'},function(rtn_data) {
				var rtn_data_arr=JSON.parse(rtn_data);
				if(rtn_data_arr.status!==undefined && rtn_data_arr.status===false){
					$('#emailERROR').remove();
					$('#email').after('<label for="email" generated="true" class="error" id="emailERROR">'+rtn_data_arr.msg+'</label>');
					$('button').prop('disabled',false);
					} else {
						form.submit();
					}
			});
    }
  });
});
</script>
@endsection