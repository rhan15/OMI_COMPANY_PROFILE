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

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('ReCaptcha', {
            'sitekey' : '6LdPg_QZAAAAAJ2ewD43vbEhhUCBDbdt0A-vPaaB'
            });
        };
    </script>
</head>

<body onload="getProvince();getProvince2();">
    <!-- Header -->
    @include('web-omi.template.register_header')
    <!-- /Header -->

    <!-- Body_Berita -->
    <div class="container berita-container">
        <form action="{{url('/registrasi_omi')}}" method="post" id="form-registrasi">
            {{ csrf_field() }}
        <div style="text-align: left;margin-top:30px;">
            <h3>Pendaftaran Waralaba</h3>
        </div>

        <div>
            Bagi Anda yang berminat mendaftar waralaba OMI, silahkan lengkapi formulir dibawah ini. Wilayah Operasional OMI mencakup Jabotabek, Semarang, Yogyakarta, Surabaya, Medan, dan Makassar.
        </div>

        <div class="mt-5 mb-4">
            <h4>Data Pribadi</h4>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Nama Lengkap</h5></div>
            <div class="col-sm-12 col-md-9">
                <input id="namalengkap" type="text" class="form-control form-control-sm" placeholder="Nama Lengkap" name="name" required oninvalid="this.setCustomValidity('Nama tidak boleh kosong')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Nomor KTP</h5></div>
            <div class="col-sm-12 col-md-6">
                <input id="nomorktp" type="number" class="form-control form-control-sm" placeholder="Nomor KTP" name="ktp" min="1000000000000000" required oninvalid="this.setCustomValidity('Masukkan 16 digit nomor KTP')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Jenis Kelamin</h5></div>
            <div class="col-sm-12 col-md-6" id="jeniskelamin">
                <input type="radio" value="Laki-Laki" name="jenis_kelamin" style="margin-right: 5px;margin-left:15px;" checked> Laki-Laki
                <input type="radio" value="Perempuan" name="jenis_kelamin" style="margin-right: 5px;margin-left:15px;"> Perempuan
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Email</h5></div>
            <div class="col-sm-12 col-md-9">
                <input id="email" type="email" class="form-control form-control-sm" placeholder="yourmailname@email.com" name="email" required oninvalid="this.setCustomValidity('Format email salah')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Propinsi</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="provinces" name="provinsi_id" class="form-control form-control-sm" onchange="getKota()">
                    <option value="0">--Pilih Propinsi</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kota</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="cities" name="city_id" class="form-control form-control-sm" onchange="getDistrict()">
                    <option value="0">--Pilih Kota</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kecamatan</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="districts" name="district_id" class="form-control form-control-sm" onchange="getSubDistrict()">
                    <option value="0">--Pilih Kecamatan</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kelurahan</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="subdistricts" name="subdistrict_id" class="form-control form-control-sm" onchange="getKodePos()">
                    <option value="1">--Pilih Kelurahan</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Alamat</h5></div>
            <div class="col-sm-12 col-md-9">
                <textarea name="address" class="form-control" id="alamat" rows="5" required oninvalid="this.setCustomValidity('Alamat tidak boleh kosong')" onchange="this.setCustomValidity('')"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kode Pos</h5></div>
            <div class="col-sm-12 col-md-2">
                <input id="postcode" name="kodepos" type="number" class="form-control form-control-sm" placeholder="*kode pos" readonly>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Nomor HP</h5></div>
            <div class="col-sm-12 col-md-4">
                <input id="hp" type="number" name="phone_number" class="form-control form-control-sm" placeholder="" required oninvalid="this.setCustomValidity('Nomor HP tidak boleh kosong')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Pendidikan Terakhir</h5></div>
            <div class="col-sm-12 col-md-4">
                <select name="education" id="education" class="form-control form-control-sm">
                    @foreach ($education as $edu)
                        <option value="{{$edu['id']}}">{{$edu['name']}}</option>
                    @endforeach
                  </select>
            </div>
        </div>
        <div class="mt-5 mb-4">
            <h4>Data Usulan Lokasi</h4>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Propinsi</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="provinces2" name="provinsi_id_loc" class="form-control form-control-sm" onchange="getKota2();">
                    <option value="1">--Pilih Propinsi</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kota</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="cities2" name="city_loc" class="form-control form-control-sm" onchange="getDistrict2();geolock();">
                    <option value="1">--Pilih Kota</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kecamatan</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="districts2" name="district_loc" class="form-control form-control-sm" onchange="getSubDistrict2()">
                    <option value="1">--Pilih Kecamatan</option>
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kelurahan</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="subdistricts2" name="subdistrict_loc" class="form-control form-control-sm" onchange="getKodePos2();">
                    <option value="1">--Pilih Kelurahan</option>
                  </select>
            </div>
        </div>

        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kode Pos</h5></div>
            <div class="col-sm-12 col-md-2">
                <input id="postcode2" name="kodepos_loc" type="number" class="form-control form-control-sm" placeholder="*kode pos" readonly>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Alamat</h5></div>
            <div class="col-sm-12 col-md-9">
                <textarea name="address_loc" class="form-control" id="exampleFormControlTextarea1" rows="5" required oninvalid="this.setCustomValidity('Alamat tidak boleh kosong')" onchange="this.setCustomValidity('')"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Kepemilikan</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="kepemilikan" name="ownership" class="form-control form-control-sm" onchange="openBUform()">
                    {{-- <option value="0">Pilih Kepemilikan</option> --}}
                    @foreach ($ownership as $owner)
                        <option value="{{$owner['id']}}">{{ucfirst($owner['name'])}}</option>
                    @endforeach
                  </select>
            </div>
        </div>
        <div style="margin-top: 20px;"></div>
        <div id="bu" class="row" style="margin-top:10px;width:100%;border-top:1px solid gray;border-bottom:1px solid gray;padding:10px;display:none;">
            <div class="col-sm-12" style="margin-botom: 30px;text-align:center;"><h3>Informasi Badan Usaha</h3></div>
            <div class="col-sm-12 col-md-3" style="padding-left:30px;"><h5>Nama Badan Usaha</h5></div>
            <div class="col-sm-12 col-md-9">
                <input type="text" name="comp_name" id="comp_name" class="form-control form-control-sm" placeholder="Nama Perusahaan">
            </div>

            <div class="col-sm-12" style="margin-top: 10px;"></div>
            <div class="col-sm-12 col-md-3" style="padding-left:30px;"><h5>Alamat Badan Usaha</h5></div>
            <div class="col-sm-12 col-md-9">
                <textarea name="comp_address" class="form-control" id="comp_address" rows="3" placeholder="Alamat Perusahaan"></textarea>
            </div>

            <div class="col-sm-12" style="margin-top: 10px;"></div>
            <div class="col-sm-12 col-md-3" style="padding-left:30px;"><h5>Email Badan Usaha</h5></div>
            <div class="col-sm-12 col-md-9">
                <input name="comp_email" id="comp_email" type="email" class="form-control form-control-sm" placeholder="yourcompanymail@email.com">
            </div>

            <div class="col-sm-12" style="margin-top: 10px;"></div>
            <div class="col-sm-12 col-md-3" style="padding-left:30px;"><h5>Telpon Badan Usaha</h5></div>
            <div class="col-sm-12 col-md-9">
                <input name="comp_phone" id="comp_phone" type="number" class="form-control form-control-sm" placeholder="Nomor Telpon Badan Usaha">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Bentuk Lokasi</h5></div>
            <div class="col-sm-12 col-md-4">
                <select id="loc_type" name="loc_type" class="form-control form-control-sm">
                    @foreach ($location as $loc)
                        <option value="{{$loc['id']}}">{{ucfirst($loc['name'])}}</option>
                    @endforeach
                  </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Panjang</h5></div>
            <div class="col-sm-12 col-md-2">
                <input id="length" name="length" type="number" class="form-control form-control-sm" placeholder="" min="1" required oninvalid="this.setCustomValidity('Panjang lokasi tidak boleh kosong')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Lebar</h5></div>
            <div class="col-sm-12 col-md-2">
                <input id="width" name="width" type="number" class="form-control form-control-sm" placeholder="" min="1" required oninvalid="this.setCustomValidity('Lebar lokasi tidak boleh kosong')" onchange="this.setCustomValidity('')">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Jumlah Lantai</h5></div>
            <div class="col-sm-12 col-md-9">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <select id="floor" name="floor" class="form-control form-control-sm">
                            @for ($i = 0; $i < 6; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-5" style="text-align: right;">*) pilih 0 jika berupa tanah</div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="text-align: center;">
            </div>
            <div class="col-sm-12 col-md-10" style="text-align: center;margin-top:10px;margin-bottom:10px;">
                <button id="munculpeta" type="button"
                style="background: none!important;
                border: none;
                padding: 0!important;
                /*optional*/
                font-family: arial, sans-serif;
                /*input has OS specific font-family*/
                color: #069;
                text-decoration: underline;
                cursor: pointer; display:none;" onclick="bukapetanya();">Klik disini untuk Pin Alamat</button>
                <div id="petaregistrasi">
                    @include('web-omi.template.petaregistrasi')
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="col-sm-12 col-md-2" style="padding-left:30px;"><h5>Keterangan</h5></div>
            <div class="col-sm-12 col-md-9">
                <textarea name="note" class="form-control" id="note" rows="3"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top:10px;width:100%;">
            <div class="column" style="padding-left:45px;width:60px;">
                <input type="checkbox" name="setuju_box" class="form-check-input" id="setuju_box" style="width: 30px; height: 30px;" required>
            </div>
            <div class="column" style="width: calc(100% - 60px);padding-top:8px;">
                <label >Dengan ini saya menyatakan bahwa semua data yang di isi adalah benar</label>
            </div>
        </div>

        <div class="row my-1 justify-content-center my-3">
            <div class="align col-2"> </div>
            <div class="row col-sm mx-2">
                <div class="row col-12 justify-content-center warning"> Please check the box bellow to proceed</div>
                <div class="row col-12 justify-content-center" id="ReCaptcha" onclick="recaps()"></div>
                <div class="invalid-feedback d-flex justify-content-center my-1" >
                    <strong id="gCaptchaFeedback" style="display: none;">Silahkan selesaikan ReCapcha untuk melakukan registrasi.</strong>
                </div>
            </div>
        </div>

        <div class="row my-1">
            <div class="align col-2"> </div>
            <div class="col-sm mx-2 row justify-content-center">
                <button class="btn-kirim btn btn-success" type="submit" >Kirim</button>
            </div>
        </div>

    </form>
    </div>


    <div class="section"></div>
    <!-- /Body_Berita -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->
</body>

</html>

<script>
    function getProvince(){
        $.ajax({
            url: "{{url('/')}}/getprovince",
            type: "GET",
            data: {
            },
                success: function(response) {
                    var province = '<option value="0">Pilih Propinsi</option>';
                    if (response.length < 1) {
                        alert('Provinsi tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            province = province +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("provinces").innerHTML = province;
                    }
                },error: function(response) {
                    alert('Terjadi kesalahan : Provinsi tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Provinsi tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
    }
    // window.onload = getProvince;
</script>

<script>
    function getKota(){
        var id = document.getElementById("provinces").value;
        if (id == 0) {
            document.getElementById("cities").innerHTML ='<option value="0">-- Pilih Kota</option>';
            document.getElementById("districts").innerHTML ='<option value="0">-- Pilih Kecamatan</option>';
            document.getElementById("subdistricts").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getcity/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var city = '<option value="0">Pilih Kota</option>';
                    if (response.length < 1) {
                        alert('Kota tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            city = city +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("cities").innerHTML = city;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kota tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kota tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }

    }
</script>

<script>
    function getDistrict(){
        var id = document.getElementById("cities").value;
        if (id == 0) {
            document.getElementById("districts").innerHTML ='<option value="0">-- Pilih Kecamatan</option>';
            document.getElementById("subdistricts").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getdistrict/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var district = '<option value="0">Pilih Kecamatan</option>';
                    if (response.length < 1) {
                        alert('Kecamatan tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            district = district +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("districts").innerHTML = district;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kecamatan tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kecamatan tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }


    }
</script>

<script>
    function getSubDistrict(){
        var id = document.getElementById("districts").value;
        if (id == 0) {
            document.getElementById("subdistricts").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getsubdistrict/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var subdistrict = '<option value="0">Pilih Kelurahan</option>';
                    if (response.length < 1) {
                        alert('Kelurahan tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            subdistrict = subdistrict +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("subdistricts").innerHTML = subdistrict;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kelurahan tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kelurahan tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }

    }
</script>

<script>
    function getKodePos() {
        var id = document.getElementById("subdistricts").value;
        if (id == 0) {
            document.getElementById("postcode").innerHTML ='';
        } else {
            $.ajax({
            url: "{{url('/')}}/getkodepos/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    document.getElementById("postcode").value = response;
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kode Pos tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kode Pos tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }
    }
</script>


{{-- ===================================================== --}}

<script>
    function getProvince2(){
        $.ajax({
            url: "{{url('/')}}/getprovince",
            type: "GET",
            data: {
            },
                success: function(response) {
                    var province = '<option value="0">Pilih Propinsi</option>';
                    if (response.length < 1) {
                        alert('Provinsi tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            province = province +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("provinces2").innerHTML = province;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Provinsi tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Provinsi tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
    }
    // window.onload = getProvince2;
</script>

<script>
    function getKota2(){
        var id = document.getElementById("provinces2").value;
        if (id == 0) {
            document.getElementById("cities2").innerHTML ='<option value="0">-- Pilih Kota</option>';
            document.getElementById("districts2").innerHTML ='<option value="0">-- Pilih Kecamatan</option>';
            document.getElementById("subdistricts2").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getcity/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var city = '<option value="0">Pilih Kota</option>';
                    if (response.length < 1) {
                        alert('Kota tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            city = city +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("cities2").innerHTML = city;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kota tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kota tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }

    }
</script>

<script>
    function getDistrict2(){
        var id = document.getElementById("cities2").value;
        $("#munculpeta").css("display", "block");
        if (id == 0) {
            document.getElementById("districts2").innerHTML ='<option value="0">-- Pilih Kecamatan</option>';
            document.getElementById("subdistricts2").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getdistrict/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var district = '<option value="0">Pilih Kecamatan</option>';
                    if (response.length < 1) {
                        alert('Kecamatan tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            district = district +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("districts2").innerHTML = district;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kecamatan tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kecamatan tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }


    }
</script>

<script>
    function getSubDistrict2(){
        var id = document.getElementById("districts2").value;
        if (id == 0) {
            document.getElementById("subdistricts2").innerHTML ='<option value="0">-- Pilih Kelurahan</option>';
        } else {
            $.ajax({
            url: "{{url('/')}}/getsubdistrict/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    var subdistrict = '<option value="0">Pilih Kelurahan</option>';
                    if (response.length < 1) {
                        alert('Kelurahan tidak ditemukan')
                    } else {
                        for (let index = 0; index < response.length; index++) {
                            subdistrict = subdistrict +
                            '<option value="'+response[index]['id']
                            +'">'+response[index]['name']
                            +'</option>'
                        }
                        document.getElementById("subdistricts2").innerHTML = subdistrict;
                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kelurahan tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kelurahan tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }

    }
</script>

<script>
    function getKodePos2() {
        var id = document.getElementById("subdistricts2").value;
        if (id == 0) {
            document.getElementById("postcode2").innerHTML ='';
        } else {
            $.ajax({
            url: "{{url('/')}}/getkodepos/"+id,
            type: "get",
            data: {
            },
                success: function(response) {
                    // alert(response);
                    document.getElementById("postcode2").value = response;
                },error: function(response) {
                    // alert('Terjadi kesalahan : Kode Pos tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kode Pos tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
        }
    }
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>


<script>
    function openBUform() {
        var id = document.getElementById("kepemilikan").value;
        if (id ==3) {
            document.getElementById('bu').style.display = 'block';
        }else{
            document.getElementById('bu').style.display = 'none';
        }
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function ValidateRecaptcha(response){
        var recaptchaFeedback = document.getElementById('gCaptchaFeedback');
        if(response==""){
            recaptchaFeedback.style.display = "block";
            return "false";
        }else{
            recaptchaFeedback.style.display = "none";
            return "true";
        }
    }

    $("#form-registrasi").submit(function (e) {
    /* stop form from submitting normally */
    e.preventDefault();

    //data pribadi
    var name = document.getElementsByName('name')[0].value;
    var ktp = document.getElementsByName('ktp')[0].value;
    var jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val();
    var email = document.getElementsByName('email')[0].value;
    var provinsi_id = document.getElementsByName('provinsi_id')[0].value;
    var city_id = document.getElementsByName('city_id')[0].value;
    var district_id = document.getElementsByName('district_id')[0].value;
    var subdistrict_id = document.getElementsByName('subdistrict_id')[0].value;
    var address = document.getElementsByName('address')[0].value;
    var kodepos = document.getElementsByName('kodepos')[0].value;
    var phone_number = document.getElementsByName('phone_number')[0].value;
    var education = document.getElementsByName('education')[0].value;

    // data lokasi
    var provinsi_id_loc = document.getElementsByName('provinsi_id_loc')[0].value;
    var city_loc = document.getElementsByName('city_loc')[0].value;
    var district_loc = document.getElementsByName('district_loc')[0].value;
    var subdistrict_loc = document.getElementsByName('subdistrict_loc')[0].value;
    var address_loc = document.getElementsByName('address_loc')[0].value;
    var kodepos_loc = document.getElementsByName('kodepos_loc')[0].value;

    var ownership = document.getElementsByName('ownership')[0].value;
    var comp_name = document.getElementsByName('comp_name')[0].value;
    var comp_address = document.getElementsByName('comp_address')[0].value;
    var comp_email = document.getElementsByName('comp_email')[0].value;
    var comp_phone = document.getElementsByName('comp_phone')[0].value;
    var loc_type = document.getElementsByName('loc_type')[0].value;

    var length = document.getElementsByName('length')[0].value;
    var width = document.getElementsByName('width')[0].value;
    var floor = document.getElementsByName('floor')[0].value;
    var latitude = document.getElementsByName('latitude')[0].value;
    var longitude = document.getElementsByName('longitude')[0].value;
    var note = document.getElementsByName('note')[0].value;
    var setuju_box = document.getElementsByName('setuju_box')[0].value;

    // capta
    var recaptcha = grecaptcha.getResponse();

    //send data diri
    var form = new FormData();
    form.append('name', name);
    form.append('email', email);
    form.append('ktp', ktp);
    form.append('jenis_kelamin', jenis_kelamin);
    form.append('province_id', provinsi_id);
    form.append('city_id', city_id);
    form.append('district_id', district_id);
    form.append('subdistrict_id', subdistrict_id);
    form.append('address', address);
    form.append('kodepos', kodepos);
    form.append('phone_number', phone_number);
    form.append('education', education);
    // send data lokasi
    form.append('provinsi_id_loc', provinsi_id_loc);
    form.append('city_loc', city_loc);
    form.append('district_loc', district_loc);
    form.append('subdistrict_loc', subdistrict_loc);
    form.append('address_loc', address_loc);
    form.append('kodepos_loc', kodepos_loc);

    form.append('ownership', ownership);
    form.append('comp_name', comp_name);
    form.append('comp_address', comp_address);
    form.append('comp_email', comp_email);
    form.append('comp_phone', comp_phone);
    form.append('loc_type', loc_type);

    form.append('length', length);
    form.append('width', width);
    form.append('floor', floor);
    form.append('latitude', latitude);
    form.append('longitude', longitude);
    form.append('note', note);
    form.append('setuju_box', setuju_box);

    // capta
    form.append('capta', recaptcha);

    //check
    var cekCaptcha = ValidateRecaptcha(recaptcha);

    if (cekCaptcha == "true") {
        console.log("kirim");
        $.ajax({
            type: "POST",
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            url: "{{url('/')}}" + "/registrasi_omi",
            success: function (response) {
                console.log(response);
                Swal.fire({
                    position: 'center',
                    icon: response['icon'],
                    title: response['message'],
                }), setTimeout(function () {
                    // location.reload();
                }, 2000);
                }
        });
    } else {
        console.log("salah");
    }
});

</script>
