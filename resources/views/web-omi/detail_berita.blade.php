<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')
    <link rel="stylesheet" href=" {{ asset('css/web-omi/home.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/web-omi/berita.css') }}">

    <!-- Css owl carousel -->
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.theme.default.min.css') }}">
</head>

<body>
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->

    <!-- Body_Berita -->
    <div class="container content">
        <div class="container berita-container">
            <div class="section-header-berita" style="text-align: left;margin-top:30px;">
                <h2>{{$blog['title']}}</h2>
            </div>
            <div class="wrapper" style="color: gray;">
                {{$blog['created_at']->formatLocalized('%d %B %Y')}}
            </div>

            <div class="wrapper" style="margin-top:40px;">
                <img src="{{$blog['path_image']}}" onerror="this.src='{{ URL::to('/') }}/images/default-image/Default_Berita.png';this.onerror='';" alt="" style="max-width: 100%;border-radius:15px;">
            </div>

            <div class="wrapper" style="margin-top:40px;">
                @php
                    echo $blog['description'];
                @endphp
            </div>
        </div>
        <!-- /Body_Berita -->

        <!-- Berita Lainnya -->
        <div class="berita" style="width: 80%;margin:auto;">
            <div class="section-header">
                <h2>Berita Lainnya</h2>
            </div>
            <div class="section-content">
                <div class="berita-terkini">
                    <div class="owl-carousel-berita-terkini owl-carousel owl-theme">
                        <?php
                            for ($i=0; $i < count($other) ; $i++) {
                        ?>
                            <div class="item">
                                <a href="{{url('/detail_berita', ['id' => $other[$i]['id']])}}">
                                    <div class="card">
                                        <div class="thumbnail">
                                            <img src="{{$other[$i]['path_image'] }}" onerror="this.src='{{ url('/') }}/images/dummy/Default_Berita.png';this.onerror='';" alt="" style="width:100%;">
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <h5 class="card-title text-center">{{$other[$i]['title']}}</h5>
                                            </div>
                                            <div class="tanggal">
                                                <p class="card-text">{{$other[$i]['created_at']->formatLocalized('%d %B %Y')}}</p>
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
        <!-- /Berita Terkini -->

        <div class="section"></div>
    </div>

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    {{-- Owl Carousel --}}
    <script src="{{ asset('js/owl-carousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('js/owl-carousel/owl.carousel.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.owl-carousel-berita-terkini').owlCarousel({
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
        });
    </script>
    <!-- /Js -->
</body>

</html>
