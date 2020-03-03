<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>CRM</title>

        <meta name="description" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" type="text/css" />
        <!-- Fonts and Styles -->
        @yield('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashmix.min.css') }}">

        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" href="{{ mix('css/themes/xwork.css') }}"> 
        <link rel="stylesheet" href="{{ asset('css/override.css') }}">

        @yield('css_after')

        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>

        <!-- Scripts -->
    </head>
    <body>

        <script src="{{ mix('/js/core/jquery.min.js') }}"></script>
        <script src="{{ mix('js/dashmix.app.js') }}"></script>
        <script src="{{ mix('js/laravel.app.js') }}"></script>
        <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark">

            <!-- Sidebar -->
            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="bg-header-dark">
                    <div class="content-header bg-white-10">
                        <!-- Logo -->
                        <a class="link-fx font-w600 font-size-lg text-white" href="/dashboard">
                            <span class="text-white-75"><img class="logo-main" src=""></span>
                        </a>
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">

                        @if (Auth::user()->hasRole('Customer'))

                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                                <i class="nav-main-link-icon si si-cursor"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                                <span class="nav-main-link-badge badge badge-pill badge-success">5</span>
                            </a>
                        </li>

                        @endif

                        @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                        <li class="nav-main-heading">Clients</li>
                        @endif

                        <li class="nav-main-item open">
                            @foreach($projects->all() as $project)

                            @if($project->canAccessProject($project,$user))

                            <a class="nav-main-link" href="/dashboard/project/{{$project->id}}/overview">
                                <i class="nav-main-link-icon si si-globe"></i>
                                <span class="nav-main-link-name">{{$project->name}}</span>
                                @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                                @if(!$project->ws_read)
                                <span class="nav-main-link-badge badge badge-pill badge-success">New</span>
                                @endif
                                @else
                                @if(!$project->client_read)
                                <span class="nav-main-link-badge badge badge-pill badge-success">New</span>
                                @endif
                                @endif
                            </a>
                            @endif

                            @endforeach
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div>
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->


                        @if (Auth::user()->hasAnyRole(['Administrator','Consultant']))


                        <div class="dropdown d-inline-block top-nav-inline-link">
                            <a class="top-nav-single-link {{ request()->route()->getName() == 'allActivityOverview' ? 'active' : ''  }}" href="/dashboard/overview">All Activity</a>
                        </div>

                        <div class="dropdown d-inline-block">
                            <a class="top-nav-single-link {{ request()->route()->getName() == 'timeTracker' ? 'active' : ''  }}" href="/dashboard/timetracker">Time Tracker</a>
                        </div>

                        <div class="dropdown d-inline-block">

                            <button type="button" class="btn btn-dual 
                                    {{ request()->route()->getName() == 'projectsAll' ? 'active' : ''  }}
                                    {{ request()->route()->getName() == 'projectsCreate' ? 'active' : ''  }}
                                    {{ request()->route()->getName() == 'projectsEdit' ? 'active' : ''  }}
                                    " id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="fa fa-fw fa-user d-sm-none "></i>
                                <span class="d-none d-sm-inline-block ">Manage Projects</span>
                                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">

                                <div class="p-2">
                                    <a class="dropdown-item" href="/dashboard/projects/all">All Projects</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/dashboard/projects/create">Add New Project</a>

                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-dual 
                                    {{ request()->route()->getName() == 'usersAll' ? 'active' : ''  }}
                                    {{ request()->route()->getName() == 'usersCreate' ? 'active' : ''  }}
                                    {{ request()->route()->getName() == 'usersEdit' ? 'active' : ''  }}
                                    " id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">Manage Users</span>
                                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">

                                <div class="p-2">
                                    <a class="dropdown-item" href="/dashboard/users/all">All Users</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/dashboard/users/create">Add New User</a>

                                </div>
                            </div>
                        </div>
                        
                         <div class="dropdown d-inline-block top-nav-inline-link">
                            <a class="top-nav-single-link {{ request()->route()->getName() == 'planningView' ? 'active' : ''  }}" href="/dashboard/planning">Planning</a>
                        </div>

                        @endif


                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div>
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{Auth::user()->name}}</span>
                                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                                    User Options
                                </div>
                                <div class="p-2">
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown -->


                    </div>
                    <!-- END Right Section -->
                </div>

                <div id="page-header-search" class="overlay-header bg-primary">
                    <div class="content-header">
                        <form class="w-100" action="/dashboard" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                    <button type="button" class="btn btn-primary" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-fw fa-times-circle"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-primary-darker">
                    <div class="content-header">
                        <div class="w-100 text-center">
                            <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-0">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">

                        </div>
                        <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                            <a class="font-w600" href="https://wildshark.co.uk" target="_blank">WildShark</a> &copy; <span data-toggle="year-copy">2018</span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>

    </body>
</html>
