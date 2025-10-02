<!DOCTYPE html>
<html>

<head>
    @include('cms-omi.template.head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CMS-OMI | Log in</title>
    <link rel="stylesheet" href="{{ asset('css/cms-omi/head.css') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .login-page, .register-page {
            background: #d4e7cc;
        }
    </style>

</head>

<body class="hold-transition login-page">

    <div id="logform" class="login-box" style="display: none;">
        <div class="login-logo">
            <a href="/cms"><b>cms</b>OMI</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{url('/cms/login_ex')}}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <!-- <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label> -->
                                {{-- error message --}}
                                @if(session()->has('error_msg'))
                                <marquee behavior="scroll" direction="left" style="color: red;font-weight:bold;">
                                    {{session('error_msg')}}
                                </marquee>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            {{-- <input type="hidden" name="mac" value="{{gethostbyaddr($_SERVER['REMOTE_ADDR'])}}"> --}}
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-lte/dist/js/adminlte.js') }}"></script>
    <script>
        function preloadFunc() {
            $.ajax({
                url: "{{url('/')}}/cms/login_status",
                type: "get",
                data: {},
                success: function(response) {
                    console.log(response);
                    if (response == 1) {
                        window.location.replace("{{url('/')}}/cms");
                    } else {
                        var x = document.getElementById("logform");
                        x.style.display = "block";
                    }
                },
                error: function(response) {
                    var x = document.getElementById("logform");
                    x.style.display = "block";
                }
            });
        }
        window.onpaint = preloadFunc();
    </script>
</body>

</html>
