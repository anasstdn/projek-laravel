<div class="sidebar-menu">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                    {{-- <a href="index.html">
                        <img src="{{asset('neon/')}}/html/neon/assets/images/logo@2x.png" width="120" alt="" />
                    </a> --}}
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{-- <p style="font-size:20pt;color:white">{{ config('app.name', 'Laravel') }}</p> --}}
                        <p style="font-size:20pt;color:white">Laravel</p>
                    </a>
                </div>

                <!-- logo collapse icon -->
                <div class="sidebar-collapse">
                    <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>


                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs">
                    <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

            </header>
            

            <ul id="main-menu" class="main-menu">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                
                <li>
                    <a href="{{url('/home')}}">
                        <i class="entypo-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                 <li>
                    <a href="{{url('/data')}}">
                        <i class="entypo-database"></i>
                        <span class="title">Import / Export from DB</span>
                    </a>
                </li>
                <li class="has-sub">
                    <a href="#">
                        <i class="entypo-tools"></i>
                        <span class="title">Master ACL</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{url('/user')}}">
                                <span class="title">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/permission')}}">
                                <span class="title">Permissions</span>
                            </a>
                        </li>
                        <li>
                            <a href="dashboard-3.html">
                                <span class="title">Roles</span>
                            </a>
                        </li>
                    </ul>
                </li>
                    <li>
                    <a href="{{url('/peramalan')}}">
                        <i class="entypo-chart-line"></i>
                        <span class="title">Peramalan</span>
                    </a>
                </li>
                
            </li>
        </ul>
    </li>
</ul>

</div>

</div>