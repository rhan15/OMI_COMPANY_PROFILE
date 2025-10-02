<link rel="stylesheet" href=" {{ asset('css/web-omi/lokasi_omi.css') }}">
<script>
    var public_host = <?php echo json_encode(url('/')); ?>;
</script>

<div class="row">
    <div class="col-sm-12 col-md-6" style="margin-bottom: 10px;">
        <span>Pilih Provinsi</span>
        <div class="btn-group">
            <select id="lok_province" class="form-control form-control-sm" onchange="change_branch()">
                <option value="1">Kota</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <span>Pilih Lokasi</span>
        <div class="btn-group">
            <select id="lok_branch" class="form-control form-control-sm" onchange="change_shop()">
                <option value="1">Branch</option>
            </select>
        </div>
    </div>
</div>
<div id="lok_shop">
    <div class="row" style="margin-top:25px;">
        <div class="col-12">
            <div class="col-12 namatoko" style="text-align: center;">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <span>Mencari Toko...</span>
            </div>
        </div>
    </div>
</div>


<script>
    function indexShop() {
        $.ajax({
            url: public_host+"/lokasitoko",
            type: "GET",
            data: {
            },
                success: function(response) {
                    console.log(response);
                    var provinces = '';
                    var branches = '';
                    var shops = '';
                    var image_toko = "{{url('/')}}/images/icon/img_toko.png";
                    if (response['status'] == 1) {
                        for (let index = 0; index < response['province'].length; index++) {
                            if (response['province'][index]['id'] == 11) {
                                provinces = provinces+'<option value="'+response['province'][index]['id']+
                                '" '+' selected>'
                                +response['province'][index]['name']+'</option>';
                            }else{
                                provinces = provinces+'<option value="'+response['province'][index]['id']+
                                '" '+'>'
                                +response['province'][index]['name']+'</option>';
                            }
                        }
                        document.getElementById("lok_province").innerHTML = provinces;

                        for (let index = 0; index < response['branch'].length; index++) {
                            branches = branches+'<option value="'+response['branch'][index]['id']+
                            '">'
                            +response['branch'][index]['branch_name']+'</option>';
                        }
                        document.getElementById("lok_branch").innerHTML = branches;

                        if (response['shop'].length < 1) {
                            console.log('toko tidak ditemukan');
                        }else{
                            for (let index = 0; index < response['shop'].length; index++) {
                                var latitude = response['shop'][index]['latitude'];
                                var logitude = response['shop'][index]['longitude'];
                                var link_gmaps = 'https://maps.google.com/?ll='+latitude+','+logitude+'';
                                shops = shops+
                                '<div class="row" style="margin-top:25px;">'+
                                '<div class="col-1.5">'+
                                    '<img src="'+image_toko+'" alt="Toko">'+
                                '</div>'+
                                '<div class="col-10">'+
                                    '<div class="col-12 namatoko">'+response['shop'][index]['shop_name']+'</div>'+
                                    '<div class="col-12">'+response['shop'][index]['address']+'</div>'+
                                    '<div class="col-12 gmaps_link">'+
                                        '<a class="spc_link_lok" href="'+link_gmaps+'" target="_blank"><span>Petunjuk arah</span></a>'+
                                    '</div></div></div>';
                            }
                            document.getElementById("lok_shop").innerHTML = shops;
                        }

                    }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Tidak dapat membaca data toko');
                    Swal.fire({
                    position: 'center',
                    text: 'Tidak dapat membaca data toko !',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });
    }

    window.onpageshow = indexShop();
</script>


<script>
    function change_branch() {
        var id = document.getElementById("lok_province").value;
        $.ajax({
            url: public_host+"/getbranch",
            type: "GET",
            data: {
                province_id:id,
            },
                success: function(response) {
                    console.log(response);
                    var branches = '';
                    var shops = '';
                    var image_toko = "{{url('/')}}/images/icon/img_toko.png";
                    if (response['branch'].length < 1) {
                        alert('Provinsi belum memiliki cabang');
                        document.getElementById("lok_branch").innerHTML = branches;
                        document.getElementById("lok_shop").innerHTML = '<div class="col-12 namatoko">Toko tidak ditemukan</div>';
                    }else{
                        for (let index = 0; index < response['branch'].length; index++) {
                            branches = branches+'<option value="'+response['branch'][index]['id']+
                            '">'
                            +response['branch'][index]['branch_name']+'</option>';
                        }
                        document.getElementById("lok_branch").innerHTML = branches;

                        if (response['shop'].length < 1) {
                            document.getElementById("lok_shop").innerHTML = '<div class="col-12 namatoko">Toko tidak ditemukan</div>';
                        }else{
                            for (let index = 0; index < response['shop'].length; index++) {
                                var latitude = response['shop'][index]['latitude'];
                                var logitude = response['shop'][index]['longitude'];
                                var link_gmaps = 'https://maps.google.com/?ll='+latitude+','+logitude+'';
                                shops = shops+
                                '<div class="row" style="margin-top:25px;">'+
                                '<div class="col-1.5">'+
                                    '<img src="'+image_toko+'" alt="Toko">'+
                                '</div>'+
                                '<div class="col-10">'+
                                    '<div class="col-12 namatoko">'+response['shop'][index]['shop_name']+'</div>'+
                                    '<div class="col-12">'+response['shop'][index]['address']+'</div>'+
                                    '<div class="col-12 gmaps_link">'+
                                        '<a class="spc_link_lok" href="'+link_gmaps+'" target="_blank"><span>Petunjuk arah</span></a>'+
                                    '</div></div></div>';
                            }
                            document.getElementById("lok_shop").innerHTML = shops;
                        }
                    }
                },error: function(response) {
                    alert('Terjadi kesalahan : Tidak dapat membaca data toko');
                    Swal.fire({
                    position: 'center',
                    text: 'Tidak dapat membaca data toko !',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
        });
    }
</script>

<script>
    function change_shop() {
        var id = document.getElementById("lok_branch").value;
        $.ajax({
            url: public_host+"/getshop",
            type: "GET",
            data: {
                branch_id:id,
            },
                success: function(response) {
                    console.log(response);
                    var shops = '';
                    var image_toko = "{{url('/')}}/images/icon/img_toko.png";
                        if (response.length < 1) {
                            document.getElementById("lok_shop").innerHTML = '<div class="col-12 namatoko">Toko tidak ditemukan</div>';
                        }else{
                            for (let index = 0; index < response.length; index++) {
                                var latitude = response[index]['latitude'];
                                var logitude = response[index]['longitude'];
                                var link_gmaps = 'https://maps.google.com/?ll='+latitude+','+logitude+'';
                                shops = shops+
                                '<div class="row" style="margin-top:25px;">'+
                                '<div class="col-1.5">'+
                                    '<img src="'+image_toko+'" alt="Toko">'+
                                '</div>'+
                                '<div class="col-10">'+
                                    '<div class="col-12 namatoko">'+response[index]['shop_name']+'</div>'+
                                    '<div class="col-12">'+response[index]['address']+'</div>'+
                                    '<div class="col-12 gmaps_link">'+
                                        '<a class="spc_link_lok" href="'+link_gmaps+'" target="_blank"><span>Petunjuk arah</span></a>'+
                                    '</div></div></div>';
                            }
                            document.getElementById("lok_shop").innerHTML = shops;
                        }
                },error: function(response) {
                    // alert('Terjadi kesalahan : Tidak dapat membaca data toko');
                    Swal.fire({
                    position: 'center',
                    text: 'Tidak dapat membaca data toko !',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
        });
    }
</script>
