{{-- get the session --}}
<?php
    session_start();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/cms')}}" class="brand-link">
        <img src="{{ asset('admin-lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CMS-OMI</span>
    </a>
    <!-- /Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="img-circle fas fa-user-circle" style="color: #fff; font-size: 2rem;"></i>
                <!-- <img src="{{ asset('admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="{{url('/cms/user/detail')}}" class="d-block">{{$_SESSION["short-name"] ?? ' '}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-child-indent nav-legacy nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('/cms')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if ($_SESSION["roles"] == 1)
                <li class="nav-item has-treeview">
                    <a href="{{url('/cms/user')}}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Kelola User
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item has-treeview">
                    <a href="{{url('/cms/banner')}}" class="nav-link">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            Kelola Banner
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/cms/blog')}}" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Kelola Berita
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-percentage"></i>
                        <p>
                            Kelola Promosi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/cms/promoType')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipe Promo</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('/cms/promosi')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Promosi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Kelola Feedback
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/cms/recipent')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Email Penerima</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/cms/feedback')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Feedback</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Kelola Cabang & Toko
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/cms/cabang')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cabang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/cms/toko')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Toko</p>
                            </a>

                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{url('/cms/pendaftaran')}}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Kelola Pendaftaran
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/cms/kontak_wilayah')}}" class="nav-link">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Kelola Kontak Wilayah
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/cms/kisah_sukses')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Kelola Kisah Sukses
                        </p>
                    </a>
                </li>

                <li class="nav-header">
                    <a class="btn btn-danger" href="{{url('/cms/logout')}}" style="width: 100%;">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /Main Sidebar Container -->

<!-- Script -->
<script>
    $(document).ready(function () {

        // set active nav-item
        //non dropdown
        $(function(){
            var current = location.href;
            // console.log("current :"+current);
            $('.nav-link').each(function(){
                var $this = $(this);
                // if the current path is like this link, make it active
                // console.log("href: "+$this.attr('href'));
                if($this.attr('href') == current){
                    // console.log($this.attr('href')+" == "+current);
                    $this.addClass('active');
                    $this.parent('li').parent('ul').parent('li').children('a').addClass('active');
                    $this.parent('li').parent('ul').parent('li').addClass('menu-open');
                }
            });
        });
    });
</script>
<!-- /Script -->
