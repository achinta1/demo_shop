@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">
								Login
                </h3>
                </div>
                <div class="panel-body">
										<form class="" role="form" method="POST" action="{{ url('/login') }}" name="loginFrm" id="loginFrm">
                        {{ csrf_field() }}
                    <fieldset>
												<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           <label for="userName" class="">E-Mail Address</label>
                              <input id="userName" class="form-control required email" name="email" value="{{ old('email') }}"  autocomplete="off" autofocus>
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
		$("#loginFrm").validate({});
	});
</script>
@endsection
