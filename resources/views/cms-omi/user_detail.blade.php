<!DOCTYPE html>
<html>

<head>
    <!-- Head -->
    @include('cms-omi.template.head')
    <!-- /Head -->

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/toastr/toastr.min.css') }}">

    <!-- Style -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        table img {
            width: auto;
            height: 50px;
        }

        table tr {
            cursor: pointer;
        }

        .loading {
            visibility: hidden;
        }

        #preview-img {
            margin-left: auto;
            margin-right: auto;
            max-height: 300px;
            max-width: 100%;
        }
    </style>
    <!-- /Style -->

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar top -->
        @include('cms-omi.template.navbar-top')
        <!-- /Navbar top -->

        <!-- Navbar top -->
        @include('cms-omi.template.left-sidebar')
        <!-- /Navbar top -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Detail User</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Detail User</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="card-body">
                <div class="row" style="width: 100%;">
                    <div class="col-3">
                        <i class="fa fa-user" aria-hidden="true" style="font-size: 20vw;"></i>
                        {{-- <img src="{{ asset('admin-lte/dist/img/user2-160x160.jpg') }}" alt="User" style="width:100%;"> --}}
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div style="padding: 10px;">
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-12" style="font-size: 20px;font-weight:bold;border-bottom:1px solid gray;">
                                    User Information
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    Full Name
                                </div>
                                <div class="col-8">
                                    {{$_SESSION['full-name']}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    Short Name
                                </div>
                                <div class="col-8">
                                    {{$_SESSION['short-name']}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    Email
                                </div>
                                <div class="col-8">
                                    {{$_SESSION['email']}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    Role
                                </div>
                                <div class="col-8" style="font-weight:bold;">
                                    {{$_SESSION['role_name']}}
                                </div>
                            </div>
                            <div class="row" style="padding-top:10px;color:#00b300;">
                                <div class="col-12" style="font-weight:bold;">
                                    Active since - {{$_SESSION['created_at']->formatLocalized('%d %B %Y')}}
                                </div>
                            </div>
                            <div class="row" style="width: 100%;padding-left:8px;border-bottom:1px solid gray;margin-top:25px;font-size: 20px;font-weight:bold;">
                                Ganti Password
                            </div>
                            <form action="{{url('/cms/user/reset_password')}}" method="post">
                                {{ csrf_field() }}
                                <div class="row" style="padding-top: 10px;background-color:#d9d9d9;width:100%;">
                                    <div class="col-lg-3 col-md-12" style="margin: auto;">Current Password</div>
                                    <div class="col-lg-9 col-md-12">
                                        <input class="form-control form-control-sm" type="password" placeholder="Current Password" name="old_password" style="max-width:250px;" required>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 10px;background-color:#d9d9d9;width:100%;">
                                    <div class="col-lg-3 col-md-12" style="margin: auto;">New Password</div>
                                    <div class="col-lg-9 col-md-12">
                                        <input class="form-control form-control-sm" type="password" placeholder="New Password" name="new_password" style="max-width:250px;" required>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 10px;padding-bottom:10px;background-color:#d9d9d9;width:100%;">
                                    <div class="col-lg-3 col-md-12" style="margin: auto;">Confirm New Password</div>
                                    <div class="col-lg-9 col-md-12">
                                        <input class="form-control form-control-sm" type="password" placeholder="Retype New Password" name="confirm_password" style="max-width:250px;" required>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 10px;padding-bottom:10px;background-color:#d9d9d9;border-bottom-right-radius: 10px;width:100%;">
                                    <div class="col-lg-3 col-md-12"></div>
                                    <div class="col-lg-9 col-md-12">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SweetAlert2 -->
    <script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('admin-lte/plugins/toastr/toastr.min.js') }}"></script>

        <!-- footer -->
        @include('cms-omi.template.footer')
        <!-- /footer -->
</body>

</html>
