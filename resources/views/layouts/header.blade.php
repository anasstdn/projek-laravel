   <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Logo -->
                        <div class="content-header-item mr-5">
                            <a class="link-effect font-w600 font-size-xl" href="{{url('/')}}">
                              <i class="si si-graph text-primary"></i>
                                <span class="text-dual-primary-dark">Laravel</span><span class="text-primary">Forecast</span>
                            </a>
                        </div>
                        <!-- END Logo -->

                        <!-- Open Search Section -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    {{--     <button type="button" class="btn btn-rounded btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
                            <i class="fa fa-search mr-5"></i> Search
                        </button> --}}
                        <!-- END Open Search Section -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="content-header-section d-none d-lg-block">
                        <!-- Header Navigation -->
                        <!--
                        Desktop Navigation, mobile navigation can be found in #sidebar

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        If your sidebar menu includes headings, they won't be visible in your header navigation by default
                        If your sidebar menu includes icons and you would like to hide them, you can add the class 'nav-main-header-no-icons'
                        -->
                        <ul class="nav-main-header">
                        	@if(\Auth::user()->can('read-home-menu'))
                            <li>
                                <a class="" href="{{url('/home')}}"><i class="si si-home"></i>Dashboard</a>
                            </li>
                            @endif
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i>Master ACL</a>
                                <ul>
                                    <li>
                                        <a href="{{url('/user')}}">Users</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/permission')}}">Permission</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/role')}}">Roles</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-wrench"></i>Tools</a>
                                <ul>
                                    <li>
                                        <a href="{{url('/data')}}">Import / Export to DB</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href=""><i class="si si-basket"></i>Sales</a>
                            </li>
                            <li>
                                <a href=""><i class="si si-pie-chart"></i>Chart</a>
                            </li>
                            <li>
                                <a href=""><i class="si si-graph"></i>Forecasting</a>
                            </li>
                        </ul>


                  
                        <!-- END Header Navigation -->

                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <div class="content-header-section">
                         <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                                <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">User</h5>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="si si-logout mr-5"></i> Sign Out
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </a>
                            </div>
                        </div>
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Search -->
                <div id="page-header-search" class="overlay-header">
                    <div class="content-header content-header-fullrow">
                        <form>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Close Search Section -->
                                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                    <button type="button" class="btn btn-secondary px-15" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <!-- END Close Search Section -->
                                </div>
                                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary px-15">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->