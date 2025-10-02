<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')

    <link rel="stylesheet" href=" {{ asset('css/web-omi/hubungi-kami.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('ReCaptcha', {
                'sitekey' : '6LdPg_QZAAAAAJ2ewD43vbEhhUCBDbdt0A-vPaaB'
            });
        };
    </script>
</head>

<body>
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->

    <!-- Hubungi Kami Content -->
    <div class="container py-4">
        <div class="section">
            <div class="section-header">
                <h2>Kirim Pertanyaan atau Saran</h2>
            </div>
        </div>

        <div class="row">
            <!-- Info Kantor -->
            <div class="col-lg-4 my-3">
                <div class="maps justify-content-center mb-3">
                    @include('web-omi.template.small_maps')
                </div>
                <div class="row my-2">
                    <div class="infoKantor col-12">{{$Company[0]['title']}}</div>
                    <div class="infoLabel col-12">{{$Company[0]['subtitle']}}</div>
                    <div class="infoDetail col-12">{{$Company[0]['address']}}</div>
                    {{-- <div class="infoDetail col-12">Telepon : {{$Company[0]['phone']}} <br> {{$Company[0]['fax']}} <br> Email : {{$Company[0]['email']}}</div> --}}
                    <div class="infoDetail col-12">
                        Telepon : 021-50897400, 021-50897411 <br>[ Ext. 1643/1644 ] <br><br>
                        Whatsapp : 0822 1712 1001 <br>
                        Email : waralaba@omifranchise.co.id
                    </div>
                    <div class="col-12">
                        <a href="#contact-person"><button class="btn-kontak">Kontak Per Wilayah</button> </a>
                    </div>
                </div>
            </div>
            <!-- /Info Kantor -->

            <!-- Form Saran -->
            <div class="col-lg-8 my-3 formulir">
                <form id="form-saran" method="">
                    <div class="container">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="user-name" id="user-name" required>
                            </div>
                        </div>

                        <div class="row my-1">
                            <label for="" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" id="email" required>
                                <div class="invalid-feedback d-flex justify-content-start my-1" >
                                    <strong id="EmailFeedback" style="display: none;">Format email anda salah!</strong>
                                </div>
                            </div>

                        </div>

                        <div class="row my-1">
                            <label for="" class="col-sm-2 col-form-label">Handphone</label>
                            <div class="col-sm-10">
                                <input type="tel" pattern="[0-9].{6,14}" name="phone" id="phone" oninvalid="this.setCustomValidity('Masukkan Sesuai Format 08XX-XXXX-XXXX')" required>
                            </div>
                        </div>

                        <div class="row my-1">
                                <label for="" class="col-sm-2 col-form-label">Kota/Provinsi</label>
                            <div class="col-sm-10">
                                <input type="text" name="provinsi" id="provinsi" required>
                            </div>
                        </div>

                        <div class="row my-1">
                            <label for="" class="col-sm-2 col-form-label">Pesan</label>
                            <div class="col-sm-10">
                                <textarea name="content" id="content" cols="30" rows="10" required></textarea>
                            </div>
                        </div>

                        <div class="row my-1 justify-content-center">
                            <div class="align col-2"> </div>
                            <div class="col-sm mx-2 warning py-2">*) semua field wajib diisi</div>
                        </div>

                        <div class="row my-1 justify-content-center my-3">
                            <div class="align col-2"> </div>
                            <div class="row col-sm mx-2">
                                <div class="row col-12 justify-content-center warning"> Please check the box bellow to proceed</div>
                                <div class="row col-12 justify-content-center" id="ReCaptcha"></div>
                                <div class="invalid-feedback d-flex justify-content-center my-1" >
                                    <strong id="gCaptchaFeedback" style="display: none;">Silahkan selesaikan ReCapcha untuk mengirim saran.</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row my-1">
                            <div class="align col-2"> </div>
                            <div class="col-sm mx-2 row justify-content-center">
                                <button class="btn-kirim" type="submit">Kirim</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /Form Saran -->
        </div>
    </div>

    <div><span class="line"></span></div>
    <!-- Daftar Contact -->
    <div id="contact-person" class="container">
        <div class="section">
            <div class="section-header">
                <h2> Daftar Kontak Per Wilayah</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($Contact as $Contacts)
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-header">{{$Contacts['area']}}</div>
                        <div class="row card-body">
                            <div class="col-md card-text">
                                <div class="card-name">{{$Contacts['name']}}</div>
                                <div class="row m-1">
                                    <div class="card-icon"> <img src="{{ asset('images/icon/contact_1.png') }}"></div>
                                    <div class="my-1">
                                        <div class="contact-title">Handphone</div>
                                        <div class="contact-info">0{{$Contacts['handphone']}} </div>
                                    </div>
                                </div>
                                <a href="https://api.whatsapp.com/send/?phone=62{{$Contacts['whatsapp']}}&text=Halo%21Saya+ingin+bertanya+tentang+OMI&app_absent=0">
                                    <div class="row m-1">
                                        <div class="card-icon"> <img src="{{ asset('images/icon/contact_2.png') }}"></div>
                                        <div class="my-1">
                                            <div class="contact-title">Whatsapp</div>
                                            <div class="contact-info">0{{$Contacts['whatsapp']}} </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="row m-1">
                                    <div class="card-icon"> <img src="{{ asset('images/icon/contact_3.png') }}"></div>
                                    <div class="my-1">
                                        <div class="contact-title">Phone</div>
                                        <div class="contact-info">{{$Contacts['phone']}} </div>
                                    </div>
                                </div>
                                <div class="row m-1">
                                    <div class="card-icon"> <img src="{{ asset('images/icon/contact_4.png') }}"> </div>
                                    <div class="my-1">
                                        <div class="contact-title">Email</div>
                                        <div class="contact-info">{{$Contacts['email']}} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /Daftar Contact -->


    <!-- /Hubungi Kami Content -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    <!-- Js -->
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>
    <script src="{{ asset('js/web-omi/hubungi_kami.js')}}"></script>
    <script>
        let urlSaran ="{{url('/')}}"
    </script>
    <!-- /Js -->
</body>

</html>
