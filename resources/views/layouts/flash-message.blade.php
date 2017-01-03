<div id="notifyMessage">
@if ($flash_message = Session::get('flash-success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $flash_message }}</strong>
</div>
@endif

@if ($flash_message = Session::get('flash-error'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $flash_message }}</strong>
</div>
@endif

@if ($flash_message = Session::get('flash-warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $flash_message }}</strong>
</div>
@endif

@if ($flash_message = Session::get('flash-info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $flash_message }}</strong>
</div>
@endif

@if ($flash_message = Session::get('flash-error-list'))
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<ul class="error-list">
		@foreach($flash_message as $key=>$error)
		<li>{{$error}}</li>
		@endforeach
	</ul>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	Internal server error. Please try again later.
</div>
@endif
</div>