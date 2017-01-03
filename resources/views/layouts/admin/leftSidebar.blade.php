@if(Auth::user())
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <!-- /.navbar-header -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand admin_title" href="{{ url('/admin') }}">
					<img src="{{URL::to('public/admin/images/site_logo_368x74.png') }}"  style="margin-top:-9px" width="200px" height="40px" alt="">
        </a>
    </div>
    <!-- /.navbar-header -->
    <!-- /.dropdown -->
    <div class="btn-group nav navbar-top-links navbar-right drop-down-top">
        <a id="btn-append-to-single-button" type="button" class="btn btn-primary header-togl-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/admin/profile') }}">My Profile</a></li>
            <li><a href="{{ url('/admin/change-password') }}">Change Password</a></li>
            <li>						
						<a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
						<form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
						</li>
        </ul>
    </div>
    <!-- /.dropdown -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav left-side-ul-sec" id="side-menu">
                 <!--  :::: Dashboard ::::   -->
                <li @if(isset($data['left_panel_parent']) && $data['left_panel_parent']=='dashboard') class="active left-sidebar-parent dashboard-home" @else class="left-sidebar-parent dashboard-home" @endif
								>
									<a class="nav-group-li-sec" href="{{ url('/admin/dashboard') }}" title="Dashboard"><i class="fa fa-fw fa-home fa-lg"></i>&nbsp;Dashboard</a>
                </li>
                <!--  :::: Site-Settings ::::   -->
               
                <li @if(Request::segment(2) == 'site-setting') class="active left-sidebar-parent" @else class="left-sidebar-parent" @endif>
                    <a class="nav-group-li-sec" href="{{ url('/admin/site-setting') }}"><i class="fa fa-fw fa-cogs fa-lg"></i>&nbsp;Site Settings</a>
                </li>

                <!--  :::: Brand ::::   --> 
                <li @if(isset($data['left_panel_parent']) && $data['left_panel_parent']== 'brandParent') class="active left-sidebar-parent" @else class="left-sidebar-parent" @endif>
                    <a class="nav-group-li-sec" href="javascript:void(0)"><i class="fa fa-slack fa-lg"></i>&nbsp;Manage Brand<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{url('/admin/brand-list') }}" @if(isset($data['left_panel_sub']) && $data['left_panel_sub']=='brandChild') class="active left-sidebar-sub" @else class="left-sidebar-sub" @endif  title="Brand List">&nbsp;Brand List</a></li>
                    </ul>
                </li>
								<!--  :::: category ::::   --> 
                <li @if(isset($data['left_panel_parent']) && $data['left_panel_parent']== 'categoryParent') class="active left-sidebar-parent" @else class="left-sidebar-parent" @endif>
                    <a class="nav-group-li-sec" href="javascript:void(0)"><i class="fa fa-slack fa-lg"></i>&nbsp;Manage Categories<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{url('/admin/category-list') }}"  @if(isset($data['left_panel_sub']) && $data['left_panel_sub']== 'categoryChild') class="active left-sidebar-sub" @else class="left-sidebar-sub" @endif title="Category List">&nbsp;Category List</a></li>
                    </ul>
										<ul class="nav nav-second-level">
                        <li><a href="{{url('/admin/sub-category-list') }}"  @if(isset($data['left_panel_sub']) && $data['left_panel_sub']== 'subCategoryChild') class="active left-sidebar-sub" @else class="left-sidebar-sub" @endif title="Sub Category List">&nbsp;Sub Category List</a></li>
                    </ul>
                </li>
								<!--  :::: Products ::::   --> 
                <li @if(isset($data['left_panel_parent']) && $data['left_panel_parent']== 'productParent') class="active left-sidebar-parent" @else class="left-sidebar-parent" @endif>
                    <a class="nav-group-li-sec" href="javascript:void(0)"><i class="fa fa-slack fa-lg"></i>&nbsp;Manage Products<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{url('/admin/product-list') }}" @if(isset($data['left_panel_sub']) && $data['left_panel_sub']=='productChild') class="active left-sidebar-sub" @else class="left-sidebar-sub" @endif  title="Brand List">&nbsp;Product List</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.navbar-static-side -->
</nav>
@endif