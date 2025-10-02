<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')

    <link rel="stylesheet" href=" {{ asset('css/web-omi/home.css') }}">

    <!-- Css owl carousel -->
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.theme.default.min.css') }}">

    <style>

        .owl-carousel-promo {
            width: 90%;
            margin-left: 5%;
            /* margin-right: 40px; */
        }



    </style>
</head>

<body>
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->

    <!-- Home-Content -->
    <div class="container content">
        <!-- <div class="eclipse1"></div>
        <div class="eclipse2"></div> -->

        <!-- Banner -->
        <div class="banner">
            <div class="container">
                <!-- jumbotron/Banner -->
                <div class="owl-carousel-banner owl-carousel owl-theme">
                    @foreach ($banners as $banner)
                        @if($banner['is_clickable'])
                            <div class="item">
                                <a href="{{ $banner['onclick_url'] }}" <?php if ($banner['is_newtab']) { ?> target="_blank" <?php } ?>>
                                    <img src="{{ $banner['path_image'] }}" onerror="this.src='{{asset('/images/placeholder/Banner 3_1.png')}}';this.onerror='';" alt="">
                                </a>
                            </div>
                        @else
                            <div class="item">
                                <a>
                                    <img src="{{ $banner['path_image'] }}" onerror="this.src='{{asset('/images/placeholder/Banner 3_1.png')}}';this.onerror='';" alt="">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- /jumbotron/Banner -->

                <!-- slider promo -->
                <div class="owl-carousel-promo owl-carousel owl-theme">
                    @foreach ($promo_type as $pt)
                        <div class="item">
                            <a href="{{ url('/') }}/promo/{{$pt['id']}}" target="_blank">
                                <img src="{{ $pt['path_image'] }}" onerror="this.src='{{-- asset('images/default-image/Default_Banner_Utama.png') --}}';this.onerror='';" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- /slider promo -->
            </div>
        </div>
        <!-- /Banner -->


        <!-- sparator -->
        <!-- <div class="container mb-2">
            <div class="separator">
            </div>
        </div> -->
        <!-- /sparator -->

        <!-- welcome -->
        <div class="section welcome">
            <div class="container">
                {{-- <div class="section-header">
                    <h2>Selamat Datang di Waralaba OMI</h2>
                </div> --}}
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="{{ url('/') }}/images/beranda.jpg" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="quote text-md-left text-center">
                            <div class="row" style="text-align: center;font-weight:bold;">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12" style="font-size: 50px;color:#F1CF00;">10</div>
                                        <div class="col-12" style="margin-bottom: 30px;">Propinsi</div>

                                        <div class="col-12" style="font-size: 50px;color:#F1CF00;">600+</div>
                                        <div class="col-12" style="margin-bottom: 30px;">Toko</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12" style="font-size: 50px;color:#F1CF00;">152</div>
                                        <div class="col-12" style="margin-bottom: 30px;">Kota/Kabupaten</div>

                                        <div class="col-12" style="font-size: 50px;color:#F1CF00;">250+</div>
                                        <div class="col-12" style="margin-bottom: 30px;">Koperasi</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /welcome -->

        <!-- Produk Bisnis -->
        <div class="section produk">
            <div class="container">
                <div class="section-header">
                    <h2>Mengapa Memilih OMI</h2>
                </div>
                <div class="section-content">
                    <div class="produk-bisnis">


                        <div class="owl-carousel-produk-bisnis owl-carousel owl-theme">
                            <?php
                                // foreach ($products as $product) {
                            ?>
                            <div class="item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container logo">
                                            <div class="row icon">
                                                <img src="{{asset('images/icon/home_credit-card 1.png')}}" alt="">
                                            </div>
                                        </div>
                                        <h5 class="card-title text-center">Kredit Anggota</h5>

                                        <p class="card-text text-left">Memfasilitasi pencatatan penjualan bagi koperasi yang memiliki anggota.</p>

                                        <!-- <div class="deskripsi">
                                            <a href="{{-- url('/bisnis?menu='.str_replace(' ', '_', $product['title'])) --}}" class="btn btn-primary card-link">Selengkapnya</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container logo">
                                            <div class="row icon">
                                                <img src="{{asset('images/icon/home_cash-register 1.png')}}" alt="">
                                            </div>
                                        </div>
                                        <h5 class="card-title text-center">Kasir Modern</h5>
                                        <p class="card-text text-left">Sistem penjualan yang memiliki berbagai Fitur untuk memudahkan anda dalam mengolah minimarket modern.</p>
                                        <!-- <div class="deskripsi">
                                            <a href="{{-- url('/bisnis?menu='.str_replace(' ', '_', $product['title'])) --}}" class="btn btn-primary card-link">Selengkapnya</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container logo">
                                            <div class="row icon">
                                                <img src="{{asset('images/icon/home_delivery 1.png')}}" alt="">
                                            </div>
                                        </div>
                                        <h5 class="card-title text-center">Stok Terjamin</h5>
                                        <p class="card-text text-left">Dikirimkan oleh INDOGROSIR dan telah disesuaikan dengan kebutuhan Toko OMI untuk menghindari barang Over Stok.</p>
                                        <!-- <div class="deskripsi">
                                            <a href="{{-- url('/bisnis?menu='.str_replace(' ', '_', $product['title'])) --}}" class="btn btn-primary card-link">Selengkapnya</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container logo">
                                            <div class="row icon">
                                                <img src="{{asset('images/icon/home_coupon.png')}}" alt="">
                                            </div>
                                        </div>
                                        <h5 class="card-title text-center">Harga Bersaing</h5>
                                        <p class="card-text text-left">Dengan beragam promo dari INDOGROSIR, Anda akan memiliki harga jual yang menarik serta menguntungkan.</p>
                                        <!-- <div class="deskripsi">
                                            <a href="{{-- url('/bisnis?menu='.str_replace(' ', '_', $product['title'])) --}}" class="btn btn-primary card-link">Selengkapnya</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <?php
                                // }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Produk Bisnis -->

        <!-- video -->
        <div class="section video">
            <div class="container">
                <div class="section-header">
                    <h2>Kisah Sukses OMI </h2>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="owl-carousel-kisah owl-carousel owl-theme">
                            @foreach ($Testimonials as $Testimoni)
                            @if ($Testimoni['flag_default']==1)
                                @if ($Testimoni['is_video']==1)
                                    <div class="item-video">
                                        <iframe width="90%" height="300" frameBorder="0" src="{{$Testimoni['url']}}" allowfullscreen></iframe>
                                    </div>
                                @else
                                <div class="item-video">
                                    <img width="90%" height="300" src="{{asset('images/dummy') }}/{{$Testimoni['url']}}" alt="">
                                </div>
                                @endif
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /video -->

        <!-- Daftar Sekarang -->
        <div class="section daftar">
            <div class="bg" style="background-image: url('{{asset('images/background/home_daftar.png')}}')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Tertarik Mendaftar OMI? Tunggu apalagi, Yuk gabung bersama jaringan waralaba Kami!</h2>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <a href="{{url('/registrasi')}}" class="btn btn-lg btn-danger mt-auto mb-auto">Daftar Sekarang!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Daftar Sekarang -->


        <!-- Berita Terkini -->
        <div class="section berita">
            <div class="container">
                <div class="section-header">
                    <h2>Berita Terkini</h2>
                </div>
                <div class="section-content">
                    <div class="berita-terkini">
                        <div class="owl-carousel-berita-terkini owl-carousel owl-theme">
                            <?php
                                for ($i=0; $i < count($blogs) ; $i++) {
                            ?>
                                <div class="item">
                                    <a href="{{ url('/') }}/detail_berita/{{$blogs[$i]['id']}}">
                                        <div class="card">
                                            <div class="thumbnail">
                                                <img src="{{ $blogs[$i]['path_image'] }}" onerror="this.src='{{ url('/') }}/images/dummy/Default_Berita.png';this.onerror='';" alt="" style="height:200px;width:100%;">
                                            </div>
                                            <div class="card-body">
                                                <div class="tanggal">
                                                    <p class="card-text">{{ $blogs[$i]['created_at']->formatLocalized('%d %B %Y') }}</p>
                                                </div>

                                                <div class="title">
                                                    <h5 class="card-title text-center"><?= strip_tags($blogs[$i]['description']) ?></h5>
                                                </div>
                                                <div class="selengkapnya">
                                                    <a href="{{ url('/') }}/detail_berita/{{$blogs[$i]['id']}}">Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Berita Terkini -->
    </div>
    <!-- /Home-Content -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    <!-- Js -->
    {{-- Owl Carousel --}}
    <script src="{{ asset('js/owl-carousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('js/owl-carousel/owl.carousel.min.js')}}"></script>

    <script>
        $(document).ready(function() {

            $('.owl-carousel-banner').owlCarousel({
                loop: true,
                singleItem: false,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                }
            });

            $('.owl-carousel-promo').owlCarousel({
                loop: true,
                singleItem: false,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 7000,
                smartSpeed: 1000,
                nav: true,
                dots: false,
                navText : ['<i class="fa fa-caret-left" aria-hidden="true"></i>','<i class="fa fa-caret-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 2
                    },
                    768: {
                        items: 2
                    },
                    990: {
                        items: 3
                    },
                }
            });

            $('.owl-carousel-kisah').owlCarousel({
                loop: true,
                video: true,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                }
            });

            $('.owl-carousel-produk-bisnis').owlCarousel({
                loop: false,
                singleItem: false,
                margin: 10,
                autoplay: true,
                smartSpeed: 500,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    },
                    1200: {
                        items: 4
                    }
                }
            });

            $('.owl-carousel-berita-terkini').owlCarousel({
                loop: false,
                singleItem: false,
                margin: 10,
                autoplay: true,
                smartSpeed: 500,
                autoplayTimeout: 10000,
                nav: false,
                dots: false,
                autoHeight: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    768: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    },
                    1200: {
                        items: 3
                    }
                }
            });

            $('.owl-carousel-promo').find('.owl-nav').removeClass('disabled');
            $('.owl-carousel-promo').on('changed.owl.carousel', function(event) {
                $(this).find('.owl-nav').removeClass('disabled');
            });
        });


    </script>
    <!-- /Js -->

</body>

</html>
