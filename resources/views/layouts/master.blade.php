@if(Request::segment(1) == 'admin')
	@include('layouts.admin.head')
	@if(Request::segment(1) == 'admin' && Request::segment(2) != '')
		@include('layouts.admin.header')
		@include('layouts.admin.leftSidebar')
	@endif
	@yield('content')
	@include('layouts.admin.footer')
@else
	@include('layouts.front.head')
	@include('layouts.front.header')
	@yield('content')
	@include('layouts.front.footer')
@endif
