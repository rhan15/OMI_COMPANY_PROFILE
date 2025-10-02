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

<body onload="load_promos();">
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->
    <!-- Body_Berita -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container content">
        <div class="berita-container">
            <div class="berita-section" style="margin-top:30px;">
                <div class="section-header">
                    <h2 style="font-family: Mulish;
                    font-style: normal;
                    font-weight: 800;
                    font-size: 32px;
                    line-height: 40px;">Promosi</h2>
                </div>

                <div class="section-content">
                    <div class="berita-terkini">
                        <div class="owl-carousel-promosi owl-carousel owl-theme">
                            @foreach ($list_promo_type as $pt)
                                <div class="item">
                                    <a href="{{ url('/') }}/promo/{{$pt['id']}}">
                                        <div class="card">
                                            <div class="thumbnail">
                                                <img src="{{$pt['path_image']}}" onerror="this.src='{{ url('/') }}/images/dummy/Default_Berita.png';this.onerror='';" alt="" style="width:100%;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section"></div>

        <div class="container berita-container" style="margin-top: 30px;">
            <div class="berita-section">
                <div class="section-header">
                    <div class="row judul_promosi" id="judul_promosi">
                        -
                    </div>
                    <div class="row" id="periode_promo">
                        <h2 style="color: green;font-size:16px;">Periode :
                            00:00:00 -
                            00:00:00
                        </h2>
                    </div>
                </div>
                <div class="wrapper">
                    {{-- <div class="row">
                        <div class="col-sm-0 col-md-1"></div>
                        <div class="col-sm-12 col-md-4">
                            <span>Pilih Provinsi</span>
                            <div class="btn-group">
                                <select id="provinces" class="form-control form-control-sm" onchange="getBranch();">
                                    @foreach ($provinces as $province)
                                        <option value="{{$province['id']}}">{{$province['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2" style="margin-bottom: 10px;"></div>
                        <div class="col-sm-12 col-md-3">
                            <span>Pilih Cabang</span>
                            <div class="btn-group">
                                <select id="branch" class="form-control form-control-sm" onchange="getPromos(this.value)">
                                    <option value="0">-</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row" style="width:80%;margin:auto;margin-top:20px;">
                        <div id="promo_carausel" class="owl-carousel-katalog owl-carousel owl-theme">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section"></div>
    </div>
    <!-- /Body_Berita -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    {{-- Owl Carousel --}}
    <script src="{{ asset('js/owl-carousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('js/owl-carousel/owl.carousel.min.js')}}"></script>

    {{-- Blowup --}}
    <script src="{{ asset('js/blowup/blowup.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.owl-carousel-promosi').owlCarousel({
                loop: true,
                singleItem: false,
                margin: 10,
                autoplay: true,
                smartSpeed: 1000,
                nav: false,
                dots: false,
            });

            $('.owl-carousel-katalog').owlCarousel({
                loop: true,
                singleItem: false,
                margin: 10,
                autoplay: true,
                smartSpeed: 300,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                }
            });
        });
    </script>
    <!-- /Js -->
</body>

</html>

<script>
    function load_promos() {
        // getBranch();
        getPromos();
    }

    // function getBranch(){
    //     var id = document.getElementById("provinces").value;

    //     $.ajax({
    //         url: "{{url('/')}}/getbranch_promo/"+id,
    //         type: "get",
    //         data: {
    //         },
    //             success: function(response) {
    //                 // console.log(response);
    //                 var branch = '';
    //                 for (let index = 0; index < response.length; index++) {
    //                     branch = branch + '<option value="'+response[index]['id']+'">'+response[index]['branch_name']+'</option>'
    //                 }
    //                 document.getElementById("branch").innerHTML = branch;
    //                 getPromos(response[0]['id']);
    //             },error: function(response) {
    //                 Swal.fire({
    //                 position: 'center',
    //                 icon: 'error',
    //                 title: 'Cabang tidak ditemukan !',
    //                 });
    //             },
    //     });

    // }

    function getPromos() {
        var promo_type_id = <?php echo json_encode($promo_type_id); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{url('/')}}/get_promo_images",
            type: "post",
            data: {
                'promo_type_id':promo_type_id,
                // 'branch_id':branch_id,
            },
                success: function(response) {
                    console.log(response);
                    var array_images = response['img'];
                    var promo_info = response['info'];
                    var promo_images = '';
                    var count=1;
                    for (let index = 0; index < array_images.length; index++) {
                        promo_images = promo_images +
                        '<div class="item"><div class="katalog">'+
                        '<a href="'+array_images[index]['path_image']+'" target="_blank">'+
                        '<img class="img-katalog-'+ count +'" src="'+array_images[index]['path_image']+'" alt="" >'+
                        '</a></div></div>';
                        count++;

                    }

                    let $owl = $('.owl-carousel-katalog');
                    $owl.trigger('destroy.owl.carousel');
                    $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');

                    document.getElementById("promo_carausel").innerHTML = promo_images;

                    $owl.owlCarousel({
                        loop: false,
                        singleItem: false,
                        margin: 10,
                        autoplay: true,
                        autoplayTimeout:10000,
                        smartSpeed: 500,
                        nav: false,
                        dots: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                        }
                    });

                    count=1;
                    array_images.forEach(function () {
                        $(".img-katalog-"+count).blowup({
                            // round magnifying glass
                            round      : true,

                            // width/height of magnifying glass
                            width      : 250,
                            height     : 250,

                            // background color
                            background : "#FFF",

                            // border shadow
                            shadow     : "0 8px 17px 0 rgba(0, 0, 0, 0.2)",

                            // border styles
                            border     : "6px solid #FFF",

                            // displays cursor
                            cursor     : true,

                            // scale factor
                            scale      : 2


                        });
                        count++;
                    });

                    // promo details
                    document.getElementById("periode_promo").innerHTML = '<h2 style="color: green;font-size:16px;">Periode :'+
                        response['promo_date']+'</h2>';

                    document.getElementById("judul_promosi").innerHTML = promo_info['title'];

                },error: function(response) {
                    // alert('Terjadi kesalahan : Promo tidak tersedia');
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Promo tidak tersedia !',
                    });

                    let $owl = $('.owl-carousel-katalog');
                    $owl.trigger('destroy.owl.carousel');
                    $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');

                    document.getElementById("promo_carausel").innerHTML = promo_images;
                },
        });
    }

</script>
