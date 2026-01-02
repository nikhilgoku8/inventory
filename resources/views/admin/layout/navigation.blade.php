
<?php $userType = Session::get('userType'); ?>

<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="header_bar">
                <div class="logo_box">
                    <div class="logo">
                        <img src="{{ asset('admin/assets/images/logo.jpg') }}">
                    </div>
                </div>
                <div class="right_section">
                    <div class="admin_info">
                        <div class="admin_name">Welcome <span> {{ Session::get('username') }}</span></div>
                        <div class="last_login">
                            last login on <span>{{ date('d-M-Y H:i', strtotime(Session::get('last_login'))) }}</span>
                        </div>
                    </div>
                    <!-- <div class="purple_hollow_btn">
                        <a>My Roles</a>
                    </div> -->
                    <!-- <div class="blue_hollow_btn">
                        <a>Sign Out</a>
                    </div> -->

                    <ul class="nav navbar-top-links navbar-right">
                        
                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <!-- <li><a><i class="fa fa-key fa-fw"></i> Change Password</a></li>
                                <li class="divider"></li> -->
                                <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand"><img src="admin/assets/images/logo_admin.png"></a>
                    </div>
                    <!-- /.navbar-header -->
                    
                </div>
            </div>

            

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="menu_header">
                            <!-- <div class="user_profile">
                                <span class="user_icon"><img src="admin/assets/images/user.png" width="40"></span>
                                <span class="user_name">Welcome Admin</span>
                            </div> -->
                            <div>Menu</div>
                        </li>

                        @if(in_array(session('userType'), ['superadmin','executive']))
                            <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fa fa-line-chart" aria-hidden="true"></i> Dashboard</a></li>
                            <li><a href="{{ route('admin.scan_qr') }}" class="active">Scan QR</a></li>
                            <li><a href="{{ route('admin.admins.index') }}">Admins</a></li>
                            <li><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                            <li><a href="{{ route('admin.sub-categories.index') }}">Sub Categories</a></li>
                            <li><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li><a href="{{ route('admin.attributes.index') }}">Attributes</a></li>
                            <li><a href="{{ route('admin.attribute-values.index') }}">Attribute Values</a></li>
                            <!-- <li>
                                <a><i class="fa fa-list-ul" aria-hidden="true"></i> Enquiries<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="@{{ route('admin.enquiries.index') }}">All</a></li>
                                    <li><a href="@{{ route('admin.enquiries.enquire_now') }}">Enquire Now</a></li>
                                </ul>
                            </li> -->
                        @endif

                        @if(in_array(session('userType'), ['superadmin']))

                            <!-- <li>
                                <a><i class="fa fa-list-ul" aria-hidden="true"></i> Masters<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(in_array(session('userType'), ['superadmin']))
                                    <li><a href="{{ route('admin.admins.index') }}">Admins</a></li>
                                    @endif
                                </ul>
                            </li> -->

                            <!-- <li><a href="{{ route('admin.admins.index') }}">Admins</a></li> -->

                        @endif

                        @if(in_array(session('userType'), ['superadmin','executive']))
                        <!-- <li>
                            <a><i class="fa fa-list-alt" aria-hidden="true"></i> Inventory<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ url('nwm/productbatches'); }}">Product Batches</a></li>
                            </ul>
                        </li> -->
                        @endif
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>