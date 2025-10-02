<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('css/web-omi/template/footer.css') }}" crossorigin="anonymous">

</head>

<body>
    <!-- Footer -->
    <footer>
        <!-- footer-top -->
        <div class="footer-top">
            <div class="container">
                <div class="row mx-0 ">

                    <!-- left-section -->
                    <div class="col-lg-12">
                        <div class="row d-flex justify-content-sm-between justify-content-center">
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-md-0 mb-5 footer-content">
                                <a class="row navbar-brand" href="{{url('/')}}">
                                        <img src="{{ asset('/images/icon/logo_omi_baru.png') }}" alt="">
                                </a>
                                <div class="row footer-title mb-1">Outlet Mitra Indogrosir</div>
                                <div class="row footer-address" id="company-address">

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-md-0 mb-5 footer-content">
                                <div class="row mb-1">
                                    <h3 class="">Tentang Kami</h3>
                                </div>
                                <div class="row">
                                    <a href="{{url('/tentang-kami')}}">Sejarah OMI</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/tentang-kami')}}#VisiMisi">Visi dan Misi</a>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-md-0 mb-5 footer-content" id="layanan-keanggotaan" >
                                <div class="row mb-1">
                                    <h3 class="">Waralaba</h3>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Mengapa_OMI')}}">Mengapa OMI</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Syarat___Ketentuan')}}">Syarat dan Ketentuan</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Jenis_Investasi')}}">Jenis Investasi</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Kisah_Sukses')}}">Kisah Sukses</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Tanya_Jawab')}}">Tanya Jawab</a>
                                </div>
                                <div class="row">
                                    <a href="{{url('/waralaba?menu=Persebaran_OMI')}}">Persebaran OMI</a>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-md-0 mb-5 footer-content">
                                <div class="row mb-1">
                                    <h3 class="">Hubungi Kami</h3>
                                </div>
                                <div class="row my-2">
                                    <div class="col-1 d-flex pl-0 pr-4">
                                        <i class="fas fa-phone-square-alt justify-content-center align-self-center"></i>
                                    </div>
                                    <div class="col-10">
                                        <div class="row"><b>Hotline</b></div>
                                        <div class="row"><b>021-50897400, <br> 021-50897411 <br> [ Ext. 1643/1644 ]</b></div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-1 d-flex pl-0 pr-4">
                                        <i class="fab fa-whatsapp justify-content-center align-self-center"></i>
                                    </div>
                                    <div class="col-10">
                                        <div class="row"><b>Whatsapp</b></div>
                                        <div class="row"><b>0822 1712 1001</b></div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-1 d-flex pl-0 pr-4">
                                        <i class="fas fa-at justify-content-center align-self-center"></i>
                                    </div>
                                    <div class="col-10">
                                        <div class="row"><b>Email</b></div>
                                        <div class="row"><b>waralaba@omifranchise.co.id</b></div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <a href="{{url('/registrasi')}}">
                                        <button class="btn-daftar" type="submit">Daftar Sekarang!</button>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /left-section -->

                </div>
            </div>
        </div>
        <!-- /footer-top -->


        <!-- footer-bottom -->
        {{-- <div class="footer-bottom">
            <div class="container">
                <div class="row justify-content-center">
                        Copyright @2020 www.omifranchise.co.id. All rights reserved.
                </div>
            </div>
        </div> --}}
        <!-- /footer-bottom -->
    </footer>
    <!-- /Footer -->

    <script src="{{ asset('js/web-omi/template/nav-left.js') }}"></script>
    <script>
        var public_host = <?php echo json_encode(url('/')); ?>;
        $.ajax({
            url: public_host+"/office-address",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var company = (response['company']);
                var address = (company[0]['address']);
                document.getElementById("company-address").innerHTML = address;
            },
            error: function(response) {
                console.log(response);
            },
        });
    </script>

</body>

</html>
