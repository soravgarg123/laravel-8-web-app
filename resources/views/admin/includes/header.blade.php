@php
    $website_name = session('configurations')['website_name'];
@endphp
<!DOCTYPE html>
    <head>
        <title>{{$website_name}} :: {{ isset($title) ? $title : 'Admin' }}</title>  

        <!-- Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">
        <meta name="description" content="{{$website_name}}">
        <meta name="keywords" content="{{$website_name}}">
        <link rel="icon" href="{{url('assets/admin/img/favicon.ico')}}">

        <!-- CSS Files -->
        <link href="{{isSSL()}}://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        <link href="{{url('assets/admin/vendors/bower_components/animate.css/animate.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/css/sweetalert2.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/css/toastr.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/css/nprogress.css')}}" rel="stylesheet">

        <!-- Other CSS -->
        @if (!empty($css))
            @foreach ($css as $value)
                <link href="{{$value}}" rel="stylesheet">
            @endforeach
        @endif

        <link href="{{url('assets/admin/css/app.min.css')}}" rel="stylesheet">
        <link href="{{url('assets/admin/css/custom.css')}}" rel="stylesheet">

        <!-- Javascript Libraries -->
        <script src="{{url('assets/admin/vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{url('assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{url('assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{url('assets/admin/js/functions.js')}}"></script>
        <script src="{{url('assets/admin/js/jquery.validate.min.js')}}"></script>
        <script src="{{url('assets/js/sweetalert2.min.js')}}"></script>
        <script src="{{url('assets/js/toastr.min.js')}}"></script>
        <script src="{{url('assets/js/nprogress.js')}}"></script>
        <script src="{{url('assets/admin/js/custom.js')}}"></script>

        <!-- Other JS -->
        @if (!empty($js))
            @foreach ($js as $value)
                <script src="{{$value}}"></script>
            @endforeach
        @endif

        <!-- Get Base URL --> 
        <script type="text/javascript">
            var base_url = "{{ url('/').'/' }}";
            var api_url  = "{{ url('').'/api/' }}";
        </script>    
    </head>
    <body>
        <header id="header" class="clearfix" data-spy="affix" data-offset-top="65">
            <ul class="header-inner">
                
                <li class="logo">
                    <a href="{{url('admin/dashboard')}}" class="admin-heading">{{$website_name}}</a>
                    <div id="menu-trigger"><i class="zmdi zmdi-menu"></i></div>
                </li>
                
                <!-- Settings -->
                <li class="pull-right dropdown hidden-xs">
                    <a href="" data-toggle="dropdown">
                        <i class="zmdi zmdi-more-vert"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a data-toggle="fullscreen" href="javascript:void(0);"><span class="zmdi zmdi-fullscreen zmdi-hc-fw"></span> Toggle Fullscreen</a></li>
                        <li><a href="{{url('admin/change-password')}}"><span class="zmdi zmdi-key zmdi-hc-fw" aria-hidden="true"></span> Change Password</a></li>
                        <li><a href="{{url('admin/edit-profile')}}"><span class="zmdi zmdi-account zmdi-hc-fw" aria-hidden="true"></span>  Edit Profile</a></li>
                        <li><a href="javascript:void(0);" onclick="showConfirmationBox('Are you sure ?','Are you sure want to log-out? Yes /No','Yes','No','{{url('admin/dashboard/logout/')}}/{{Session::get('admin_user')['login_session_key']}}')"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
                    </ul>
                </li>
                
                <!-- Time -->
                <li class="pull-right hidden-xs">
                    <div id="time">
                        <span id="t-hours"></span>
                        <span id="t-min"></span>
                        <span id="t-sec"></span>
                    </div>
                </li>
            </ul>
        </header>