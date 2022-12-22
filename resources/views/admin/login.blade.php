<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <title>{{ @$configurations['website_name'] }} :: {{ isset($title) ? $title : 'Admin' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">
        <meta name="description" content="{{ @$configurations['website_name'] }}">
        <meta name="keywords" content="{{ @$configurations['website_name'] }}">
        <link rel="icon" href="../assets/admin/img/favicon.ico">
        <link href="../assets/admin/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="../assets/admin/css/app.min.css" rel="stylesheet">
        <link href="../assets/css/nprogress.css" rel="stylesheet">
        <link href="../assets/css/toastr.min.css" rel="stylesheet">
        <link href="../assets/admin/css/custom.css" rel="stylesheet">
    </head>
    <body class="login-content">

        <!-- Login -->
        <div class="lc-block toggled" id="l-login">
            <form id="login-form" method="POST">
                @if(!empty($configurations['website_name']))
                    <div class="lcb-float" style="margin-bottom:10px;"><img src="{{ url('uploads/logo/') }}/{{ $configurations['website_logo'] }}" alt="logo"></div>
                @endif
                 <strong>Login</strong><br/><br/>
                @csrf;

                
                @if($errors->any())
                <span class="text-danger">{{$errors->first()}}</span>
                @endif
                
	            <div class="form-group">
	                <input type="email" class="form-control input"  id="email" name="email" autocomplete="off" placeholder="Email Address" value="{{old('email')}}">
                    <span class="text-danger">
                        @error('email')
                            {{$message}}
                        @enderror
                    </span>
	            </div>
	            <div class="form-group">
	                <input type="password" class="form-control input"  id="password" name="password" placeholder="Password">
                    <span class="text-danger">
                        @error('password')
                            {{$message}}
                        @enderror
                    </span>
	            </div>
	            <div class="clearfix"></div>
	            <div class="p-relative ">
	                <div class="checkbox cr-alt">
	                    <label class="c-gray">
	                        <input type="checkbox" checked name="remember_me" value="1">
	                        <i class="input-helper"></i>
	                        Keep me signed in
	                    </label>
	                </div>
                    <br/>
	            </div>
                <button class="btn btn-block btn-primary btn-float m-t-25 login-btn">Sign In</button>
        	</form>
        </div>
        <script type="text/javascript">
            var api_url  = "{{ url('').'/api' }}";
        </script>

        <!-- Javascript Libraries -->
        <script src="../assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="../assets/admin/js/functions.js"></script>
        <script src="../assets/js/nprogress.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/admin/js/custom/login.js"></script>

        <!--  Error & Success Messages -->
        <script type="text/javascript">
            $(document).ready(function(){
                @if(Session::has('error'))
                    showToaster('error','Error !',"{{ Session::get('error')  }}")
                @endif
                @if(Session::has('success'))
                    showToaster('success','Success !',"{{ Session::get('success')  }}")
                @endif
                @if(Session::has('logout'))
                    localStorage.removeItem('login_session_key');
                    localStorage.removeItem('user_guid');
                @endif
            });
        </script>
    </body>
</html>