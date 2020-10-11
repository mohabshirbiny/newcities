<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>@yield("page_title")</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome-free/css/all.min.css') }}" />
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/jqvmap/jqvmap.min.css') }}" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('admin_assets/dist/css/adminlte.min.css') }}" />
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/daterangepicker/daterangepicker.css') }}" />
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    @if(session()->has('country_details'))
                        <li class="nav-item">
                            <button type="button" class="nav-link btn btn-default" id="user-country-modal-btn" data-toggle="modal" data-target="#user-country-modal">{{ session("country_details")->name }}</button>
                        </li>
                    @endif
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <img src="{{ asset('admin_assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;" />
                    <span class="brand-text font-weight-light">Real State</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="javascript:;" class="d-block">Hi, {{ auth()->user()->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <li class="nav-item">
                                <a href="{{ url('home') }}" class="nav-link @if(request()->segment(1) == 'home') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Home</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/article-categories') }}" class="nav-link @if(request()->segment(2) == 'article-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Article Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/articles') }}" class="nav-link @if(request()->segment(2) == 'articles') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Articles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('city-districts.index') }}" class="nav-link @if(request()->segment(2) == 'city-districts') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Cities Districts</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('cities.index') }}" class="nav-link @if(request()->segment(2) == 'cities') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Cities</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('tenders.index') }}" class="nav-link @if(request()->segment(2) == 'tenders') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Tenders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tenders-categories.index') }}" class="nav-link @if(request()->segment(2) == 'tender-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Tender Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('offers-categories.index') }}" class="nav-link @if(request()->segment(2) == 'offers-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Offers Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('offers.index') }}" class="nav-link @if(request()->segment(2) == 'offers') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Offers</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('events-categories.index') }}" class="nav-link @if(request()->segment(2) == 'events-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Events Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('events-sponsors.index') }}" class="nav-link @if(request()->segment(2) == 'events-sponsors') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Events Sponsors</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('events-organizers.index') }}" class="nav-link @if(request()->segment(2) == 'events-organizers') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Events Organizers</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('events.index') }}" class="nav-link @if(request()->segment(2) == 'events') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Events</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('jobs-categories.index') }}" class="nav-link @if(request()->segment(2) == 'jobs-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Jobs Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('jobs.index') }}" class="nav-link @if(request()->segment(2) == 'jobs') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Jobs</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('sections.index') }}" class="nav-link @if(request()->segment(2) == 'sections-data') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Sections Data</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('vendor-categories.index') }}" class="nav-link @if(request()->segment(2) == 'vendor-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Vendors Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('vendors.index') }}" class="nav-link @if(request()->segment(2) == 'vendors') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Vendors</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('service-categories.index') }}" class="nav-link @if(request()->segment(2) == 'service-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Services Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('services.index') }}" class="nav-link @if(request()->segment(2) == 'services') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Services</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('developers.index') }}" class="nav-link @if(request()->segment(2) == 'developers') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Developers</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('contractor-categories.index') }}" class="nav-link @if(request()->segment(2) == 'contractor-categories') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Contractors Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('contractors.index') }}" class="nav-link @if(request()->segment(2) == 'contractors') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Contractors</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('property-items.index') }}" class="nav-link @if(request()->segment(2) == 'property-items') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Property Items</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('property-types.index') }}" class="nav-link @if(request()->segment(2) == 'property-types') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Property Types</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('facilities.index') }}" class="nav-link @if(request()->segment(2) == 'facilities') active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Facilities</p>
                                </a>
                            </li>
                            
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            @yield("content")

            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block"><b>Version</b> 3.0.5</div>
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('admin_assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge("uibutton", $.ui.button);
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        

        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        @yield("js")

        <!-- AdminLTE App -->
        <script src="{{ asset('admin_assets/dist/js/adminlte.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('admin_assets/dist/js/demo.js') }}"></script>

        <script>
            const is_country_set = "{{ session()->has('country_details') ?? 0 }}";
        </script>
        <script src="{{ asset('admin_assets/custom/general.js') }}"></script>
        
        <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

        @if (\Session::has('success_message'))
            <script>toastr.success("{{ \Session::get('success_message') }}")</script>
        @endif

    </body>
</html>
