<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="{{asset('neon/')}}/html/neon/assets/images/favicon.ico">

    <title>Laravel Forecast</title>

    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-core.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-theme.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-forms.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/custom.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/skins/green.css">

    <script src="{{asset('neon/')}}/html/neon/assets/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


    <!-- This is needed when you send requests via Ajax -->
    <script type="text/javascript">
        var baseurl = '';
    </script>

    <div class="login-container">

        <div class="login-header login-caret">

            <div class="login-content">

                <a href="#" class="logo">
                    {{-- <img src="{{asset('neon/')}}/html/neon/assets/images/logo@2x.png" width="120" alt="" /> --}}
                    <p style="font-size:20pt">Laravel Forecast</p>
                </a>

                {{-- <p class="description">Dear user, log in to access the admin area!</p> --}}

                <!-- progress bar indicator -->
                <div class="login-progressbar-indicator">
                    <h3>43%</h3>
                    <span>logging in...</span>
                </div>
            </div>

        </div>

        <div class="login-progressbar">
            <div></div>
        </div>

        <div class="login-form">

            <div class="login-content">

                <div class="form-login-error">
                    <h3>Invalid login</h3>
                    <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
                </div>
               
                {{-- <form method="post" role="form" id="form_login"> --}}
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                        @endif
                        @if(session('warning'))
                        <div class="alert alert-warning">
                            {{session('warning')}}
                        </div>
                        @endif

                        <div class="form-group {{$errors->has('username') || $errors->has('email')?'has-error':''}}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-user"></i>
                                </div>

                                <div class="col-md-12">
                                    <input id="login" type="text" placeholder="Username or E-Mail" class="form-control" name="login" value="{{ old('username')?:old('email') }}" required autofocus>

                                    @if ($errors->has('email') || $errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username')?:$errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-key"></i>
                                </div>

                                <div class="col-md-12">
                                    <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                     {{--    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <button type="submit" onclick="show_loading_bar(100);" class="btn btn-primary btn-block btn-login">
                                <i class="entypo-login"></i>
                                Login
                            </button>
                        </div>

                   {{--      <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                               
                            </div>
                        </div> --}}

                        <!-- Implemented in v1.1.4 -->


                <!-- 
                
                You can also use other social network buttons
                <div class="form-group">
                
                    <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left twitter-button">
                        Login with Twitter
                        <i class="entypo-twitter"></i>
                    </button>
                    
                </div>
                
                <div class="form-group">
                
                    <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left google-button">
                        Login with Google+
                        <i class="entypo-gplus"></i>
                    </button>
                    
                </div> -->
                
            </form>
            
            
            <div class="login-bottom-links">

               <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?</a>
            <br />
            <a href="{{ route('register') }}">Register New User</a>
            {{-- <a href="#">ToS</a>  - <a href="#">Privacy Policy</a> --}}

        </div>

    </div>

</div>

</div>


<!-- Bottom scripts (common) -->
<script src="{{asset('neon/')}}/html/neon/assets/js/gsap/TweenMax.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/bootstrap.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/joinable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/resizeable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-api.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery.validate.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-login.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-demo.js"></script>

</body>
</html>