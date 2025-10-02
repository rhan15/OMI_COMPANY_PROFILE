<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')

    <link rel="stylesheet" href=" {{ asset('css/web-omi/berita.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/web-omi/home.css') }}">

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
            <div class="berita-section" style="margin-top: 30px;">
                <div class="section-header">
                    <h1>Berita OMI</h1>
                </div>
            </div>
            <div class="row" style="width: 100%;">
                @foreach ($blogs as $blog)
                    <div class="col-sm-12 col-md-6 col-lg-4 berita-page">
                        <a href="{{url('/detail_berita', ['id' => $blog['id']])}}">
                            <div class="card" style="margin-top: 20px;">
                                <div class="thumbnail">
                                    <img src="{{$blog['path_image']}}" onerror="this.src='{{ url('/') }}/images/dummy/Default_Berita.png';this.onerror='';" alt="" style="height:200px;width:100%;">
                                </div>
                                <div style="padding-left: 10px;margin-top:10px;">
                                    <div class="title">
                                        <h5>{{$blog['title']}}</h5>
                                    </div>
                                    <div class="tanggal">
                                        <p>{{$blog['created_at']->formatLocalized('%d %B %Y')}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

            <br>
                <div class="row card" style="width:fit-content;margin:auto;">
                    <div class="col-12" style="text-align: center;">
                        @if ($page > 1)
                            <a class="link_a" href="{{url('berita', ['page' => $page - 1])}}">Previous</a>
                            <a class="link_a" href="{{url('berita', ['page' => $page - 1])}}">{{$page - 1}}</a>
                        @endif
                        <a class="link_a" href="#" style="color: black;pointer-events: none;cursor: default;">{{$page}}</a>
                        @if ($page < $last_page)
                            <a class="link_a" href="{{url('berita', ['page' => $page + 1])}}">{{$page + 1}}</a>
                            <a class="link_a" href="{{url('berita', ['page' => $page + 1])}}">Next</a>
                        @endif
                    </div>
                </div>
        </div>
        <div class="section"></div>
    </div>
    <!-- /Body_Berita -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->
</body>

</html>
