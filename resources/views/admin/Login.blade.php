@extends('../layouts.login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">
                <?php //echo $this->Html->image('/images/'.SITE_LOGO,array('class'=>'login-logo','style'=>'background-color:#f5f5f5;','height'=>'67px'));?>
								Login
                </h3>
                </div>
                <div class="panel-body">
										<form class="" role="form" method="POST" action="{{ url('/admin/login') }}" name="loginFrm" id="loginFrm">
                        {{ csrf_field() }}
                    <fieldset>
												@if(isset($data['error_message']) && trim($data['error_message'])!="")
												<div class="message error">{{$data['error_message']}}</div>
												@elseif(isset($data['success_message']) && trim($data['success_message'])!="")
												<div class="message success">{{$data['success_message']}}</div>
												@endif
												<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           <label for="email" class="">E-Mail Address</label>
                              <input id="email" class="form-control required email" name="email" value="{{ old('email') }}"  autocomplete="off" autofocus>
                              @if ($errors->has('email'))
                                 <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
												</div>
												
												<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="">Password</label>
                             <input id="password" type="password" class="form-control required" name="password" autofocus>
                              @if ($errors->has('password'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                                </span>
                              @endif
                        </div>
																																			
												<button type="submit" class="btn btn-lg btn-success btn-block login-btn-clr">Login</button>
												<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
  	  //$("#loginFrm").validate({});
    });
</script>
@endsection
