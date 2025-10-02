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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Css owl carousel -->
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl-carousel/owl.theme.default.min.css') }}">

    <style>
        html {
            scroll-behavior: smooth;
        }

        table img {
            width: 100px;
            height: auto;
        }

        table tr {
            cursor: pointer;
        }

        .loading {
            visibility: hidden;
        }

        #preview-img-banner {
            margin-left: auto;
            margin-right: auto;
            max-height: 300px;
            max-width: 100%;
        }

        .quote-imgs-thumbs {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin: 1.5rem 0;
            padding: 0.75rem;
        }

        .quote-imgs-thumbs--hidden {
            display: none;
        }

        .img-preview-thumb {
            background: #fff;
            border: 1px solid #777;
            border-radius: 0.25rem;
            box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
            margin-right: 1rem;
            max-width: 140px;
            padding: 0.25rem;
        }

        .owl-carousel-katalog {
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }


    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="hold-transition sidebar-mini layout-fixed accent-success">

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
                            <h1 class="m-0 text-dark">Kelola Promosi</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Kelola Promosi</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <!-- form -->
            <section id="tambah-promo" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Promosi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="promoForm" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-promosi" type="text" hidden>

                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan judul promosi">
                                </div>

                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea id="description" name="description" class="form-control" rows="7" placeholder="Masukan deskripsi promosi"></textarea>
                                </div>

                                <!-- tipe promo-->
                                <div class="form-group">
                                    <label for="promo_type">Tipe Promo</label>
                                    <select id="promo_type" name="promo_type" class="form-control">
                                        @if(isset($promo_types))
                                        @foreach ($promo_types as $promo_type)
                                            <option value="{{ $promo_type['id'] }}">{{ $promo_type['title'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!-- /tipe promo-->

                                {{--
                                <!-- Province -->
                                <div class="form-group">
                                    <label for="province_id">Provinsi</label>
                                    <select id="province_id" name="province_id" class="form-control" onchange="setBranch()">
                                        @if(isset($provinces))
                                        @foreach ($provinces as $key=>$province)
                                            <option value="{{ $key }}">{{ $province['province_name'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!-- /Province -->

                                <!-- cabang-->
                                <div class="form-group">
                                    <label for="branch_id">Cabang</label>
                                    <select id="branch_id" name="branch_id" class="form-control">
                                    
                                    </select>
                                </div>
                                <!-- /cabang -->
                                --}}

                                <!-- masaberlaku-->
                                <div class="form-group">
                                    <label for="reservation">Masa Berlaku/Periode</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input required type="text" class="form-control float-right" id="reservation">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /masaberlaku-->

                                <!-- File Katalog -->
                                <div class="form-group">
                                    <label for="input-file-gambar-katalog">File Katalog</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <label id="file-gambar-katalog" for="input-file-gambar-katalog" class="custom-file-label">Pilih katalog</label>
                                            <input required class="" type="file" id="input-file-gambar-katalog" name="input-file-gambar-katalog[]" multiple oninvalid="setCustomValidity('Gambar wajib diisi')" onchange="try{setCustomValidity('')}catch(e){}"/>
                                        </div>
                                    </div>
                                    <div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>
                                </div>
                                <!-- /File Katalog -->

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button id="form-submit" class="btn btn-primary" href="" type="submit">Simpan</button>
                                <a class="btn btn-default float-right" href="" onclick="refreshForm()" role="button">Batal</a>
                            </div>
                        </form>

                    </div>
                    <!-- /.card-body -->

                    <!-- Loading -->
                    <div id="loading-form" class="overlay loading">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                    <!-- /. Loading -->

                </div>
                <!-- /.card -->
            </section>
            <!--/. form -->

            <!-- list -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Promosi</h3>

                        <div class="card-tools">
                            <form action="{{url('/cms/promosi/')}}" method="get">
                                <div class="input-group input-group-sm" style="width: 300px;">

                                    <select id="promo_types" name="promo_types" class="form-control">
                                        <option value="" disabled selected hidden>Tipe Promo</option>
                                        @if(isset($promo_types))
                                        @foreach ($promo_types as $promo_type)
                                            <?php $selected = '' ?>
                                            <?php ($promo_type['id'] == ($_GET['promo_types'] ?? '') ? $selected = 'selected' : $selected = '') ?>
                                            <option value="{{ $promo_type['id'] }}" {{$selected}}>{{ $promo_type['title'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>

                                    <a href="{{url('/cms/promosi/')}}" title="Refresh filter"><button type="button" class="btn btn-tool" ><i class="fas fa-sync-alt"></i></button></a>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Tipe Promo</th>
                                    <th>Periode</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($promos))
                                @foreach ($promos as $promo)
                                <?php
                                    $start_date = date_create($promo['start_date']);
                                    $end_date = date_create($promo['end_date']);
                                    $date_now = \Carbon\Carbon::now()->add(7, 'hour');
                                    $outdated = true;
                                    if ($start_date <= $date_now && $end_date >= $date_now) {
                                        $outdated = false;
                                    }
                                    
                                    $outdated_message = "";
                                    if ($start_date > $date_now) {
                                        $outdated_message = "Promo belum berlaku";
                                    } else if ($end_date < $date_now) {
                                        $outdated_message = "Promo sudah lewat";
                                    }
                                ?>
                                <tr id="row_{{ $promo['id'] }}" onclick="preview({{ json_encode($promo) }})" <?php if($outdated){?>data-toggle="tooltip" title="{{$outdated_message}}"<?php } ?>>
                                    <td>{{++$i}}</td>
                                    <td>{{$promo['title']}}</td>
                                    <td>{{$promo['promo_type_name']}}</td>
                                    <td data-sort='{{date_format($start_date, "Ymd")}}' <?php if($outdated){?>style="color:#dc3545"<?php } ?>>{{ date_format($start_date, "d/M/Y") }} - {{ date_format($end_date, "d/M/Y") }}</td>

                                    <td onclick="event.cancelBubble=true; return false;">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" onclick="preview({{ json_encode($promo) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                            <button type="button" onclick="edit({{ json_encode($promo) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                            <button type="button" onclick="hapus(<?= $promo['id'] ?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <!-- Loading -->
                    <div id="loading-tabel" class="overlay loading">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                    <!-- /. Loading -->

                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.list -->

            <!-- /.Main content -->

            <!-- Modal Preview -->
            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row">
                                    <img id="preview-img-banner" src="" alt="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Title</label>
                                    <input id="preview-title" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Deskripsi</label>
                                    <input id="preview-description" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Masa Berlaku</label>
                                    <input id="preview-date" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tipe Promo</label>
                                    <input id="preview-tipe" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Provinsi</label>
                                    <input id="preview-province_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Cabang</label>
                                    <input id="preview-branch_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div> -->

                                <div id="owl-carousel-katalog" class="owl-carousel-katalog owl-carousel owl-theme">

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.Modal Preview -->

        </div>
        <!-- /.content-wrapper -->

        <!-- footer -->
        @include('cms-omi.template.footer')
        <!-- /footer -->

    </div>
    <!-- ./wrapper -->

    <!-- bs-custom-file-input -->
    <script src="{{ asset('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('admin-lte/plugins/toastr/toastr.min.js') }}"></script>

    {{-- Owl Carousel --}}
    <script src="{{ asset('js/owl-carousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('js/owl-carousel/owl.carousel.min.js')}}"></script>

    {{-- Blowup --}}
    <script src="{{ asset('js/blowup/blowup.js')}}"></script>

    <!-- DataTables -->
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // var provinces = <?php // echo json_encode($provinces) ?>;
        // console.log(provinces);

        // Toast setting
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            // document.getElementById("province_id").onchange();

            bsCustomFileInput.init();

            $("#table-list").DataTable({
                "pagingType": "simple_numbers",
                "aoColumnDefs": [ {
                    "bSortable": false,
                    "aTargets": [ 4 ]
                } ],
                "language": {
                    "paginate": {
                        "next": "<i class='fas fa-angle-double-right'></i>",
                        "previous": "<i class='fas fa-angle-double-left'></i>"
                    },
                    "sSearch":"Cari",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoFiltered": "(Tersaring dari _MAX_ data)",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                }
            });

        });

        // Upload multiple img
        var imgUpload = document.getElementById('input-file-gambar-katalog'),
            imgPreview = document.getElementById('img_preview'),
            totalFiles, previewTitle, previewTitleText, img;

        imgUpload.addEventListener('change', previewImgs, false);

        // function setBranch(){
        //     console.log(provinces);
        //     let e = document.getElementById("province_id");
        //     let province_id = e.options[e.selectedIndex].value;
        //     let branch_temp = "";
        //     // console.log(provinces[province_id]['branches']);
        //     provinces[province_id]['branches'].forEach(branch => {
        //         branch_temp = branch_temp + "<option value=" + branch['branch_id'] + ">" + branch['branch_name'] + "</option>"; 
        //     });

        //     document.getElementById("branch_id").innerHTML = branch_temp;

        // }

        function previewImgs(event) {
            imgPreview.innerHTML = "";
            totalFiles = imgUpload.files.length;

            if (!!totalFiles) {
                imgPreview.classList.remove('quote-imgs-thumbs--hidden');
                previewTitle = document.createElement('p');
                previewTitle.style.fontWeight = 'bold';
                previewTitleText = document.createTextNode('Total file dipilih ' + totalFiles);
                previewTitle.appendChild(previewTitleText);
                imgPreview.appendChild(previewTitle);
            }

            for (var i = 0; i < totalFiles; i++) {
                img = document.createElement('img');
                img.src = URL.createObjectURL(event.target.files[i]);
                img.classList.add('img-preview-thumb');
                imgPreview.appendChild(img);
            }
        }

        // refreshForm
        function refreshForm() {
            location.reload();
        }

        function simpan() {
            let title = document.getElementById("title").value;
            let description = document.getElementById("description").value;

            let masaberlaku = document.getElementById("reservation").value;

            let gambar_katalog_length = document.getElementById("input-file-gambar-katalog").files.length;

            let e = document.getElementById("promo_type");
            let promo_type = e.options[e.selectedIndex].value;

            // e = document.getElementById("branch_id");
            // let branch_id = e.options[e.selectedIndex].value;

            var tombol = document.getElementById("form-submit").innerHTML;

            if (tombol.localeCompare('Simpan')) { //update

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Anda yakin ingin memperbarui data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {

                        let id = document.getElementById("id-promosi").value;

                        var form = new FormData();
                        form.append('id', id);
                        form.append('title', title);
                        form.append('description', description);
                        form.append('promo_type', promo_type);
                        // form.append('branch_id', branch_id);
                        form.append('masaberlaku', masaberlaku);

                        for (var i = 0; i < gambar_katalog_length; i++) {
                            form.append("gambar_katalog"+i, $('#input-file-gambar-katalog')[0].files[i]);
                        }
                        form.append('total_katalog', gambar_katalog_length);

                        $.ajax({
                            url: "{{url('/')}}/cms/promosi/update",
                            type: "POST",
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                document.getElementById("loading-form").style.visibility = "visible";
                            },
                            success: function(response) {
                                // console.log(response);
                                document.getElementById("loading-form").style.visibility = "hidden";

                                if (response['success'] == 1) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Promo berhasil diperbarui'
                                    })

                                    setTimeout(function(){
                                        location.reload();
                                    }, 2000);

                                }else if(response['success'] == 3){
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['message']
                                    })
                                    document.getElementById("reservation").classList.add("is-invalid");
                                }else{
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['message']
                                    })
                                }
                            },
                            error: function(response) {
                                console.log(response.responseText);
                                document.getElementById("loading-form").style.visibility = "hidden";

                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                })
                            },
                        });
                    }
                });

            } else { //simpan

                var form = new FormData();
                form.append('title', title);
                form.append('description', description);
                form.append('promo_type', promo_type);
                // form.append('branch_id', branch_id);
                form.append('masaberlaku', masaberlaku);

                for (var i = 0; i < gambar_katalog_length; i++) {
                    form.append("gambar_katalog"+i, $('#input-file-gambar-katalog')[0].files[i]);
                }
                form.append('total_katalog', gambar_katalog_length);

                // return false;

                $.ajax({
                    url: "{{url('/')}}/cms/promosi/add",
                    type: "POST",
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        document.getElementById("loading-form").style.visibility = "visible";
                    },
                    success: function(response) {
                        // console.log(response);
                        document.getElementById("loading-form").style.visibility = "hidden";

                        if (response['success'] == 1) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Promo berhasil disimpan'
                            })

                            setTimeout(function(){
                                location.reload();
                            }, 2000);

                        }else if(response['success'] == 3){
                            Toast.fire({
                                icon: 'error',
                                title: response['message']
                            })
                            document.getElementById("reservation").classList.add("is-invalid");
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: response['message']
                            })
                        }
                    },
                    error: function(response) {
                        console.log(response.responseText);
                        document.getElementById("loading-form").style.visibility = "hidden";

                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan coba lagi'
                        })
                    },
                });
            }

            return false;
        }

        // Preview
        function preview(detail) {

            document.getElementById("preview-img-banner").src = detail.path_banner;
            document.getElementById("preview-title").value = detail.title;
            document.getElementById("preview-description").value = detail.description;
            document.getElementById("preview-tipe").value = detail.promo_type_name;
            // document.getElementById("preview-province_name").value = detail.province_name;
            // document.getElementById("preview-branch_name").value = detail.branch_name;

            var dS = new Date(detail.start_date);
            var dE = new Date(detail.end_date);
            document.getElementById("preview-date").value =
                ("0" + dS.getDate()) + "/" +
                ("0" + (dS.getMonth() + 1)).slice(-2) + "/" +
                dS.getFullYear() +
                " - " +
                ("0" + dE.getDate()).slice(-2) + "/" +
                ("0" + (dE.getMonth() + 1)).slice(-2) + "/" +
                dE.getFullYear();

            var cards = "";
            var count=1;
            detail.promo_images.forEach(function (promo_image) {
                cards += "<div class='item'>"
                    + "<div class='katalog'>"
                    + "<img class='img-katalog-"+ count +"' src='"+ promo_image.path_image +"'>"
                    + "</div>"
                    + "</div>";
                count++;
            });

            let $owl = $('.owl-carousel-katalog');
            $owl.trigger('destroy.owl.carousel');
            $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');

            document.getElementById('owl-carousel-katalog').innerHTML = cards;

            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";

            $owl.owlCarousel({
                loop: false,
                singleItem: false,
                margin: 10,
                autoplay: false,
                // smartSpeed: 500,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                }
            });
            count=1;
            detail.promo_images.forEach(function () {
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

            $("#previewModal").modal('show');
            return false;
        }

        // Edit
        function edit(detail) {
            imgPreview.classList.add('quote-imgs-thumbs--hidden');
            imgPreview.innerHTML = "";
            document.getElementById("loading-form").style.visibility = "visible";
            document.getElementById("loading-tabel").style.visibility = "visible";

            console.log(detail);

            setTimeout(function(){
                document.getElementById("id-promosi").value = detail.id;
                document.getElementById("title").value = detail.title;
                document.getElementById("description").value = detail.description;
                document.getElementById("promo_type").value = detail.promo_type;
                // document.getElementById("branch_id").value = detail.branch_id;
                // document.getElementById("province_id").value = detail.province_id;
                // document.getElementById("province_id").onchange();
                // document.getElementById("branch_id").value = detail.branch_id;

                var dS = new Date(detail.start_date);
                var dE = new Date(detail.end_date);
                document.getElementById("reservation").value =
                    ("0" + dS.getDate()).slice(-2) + "/" +
                    ("0" + (dS.getMonth() + 1)).slice(-2) + "/" +
                    dS.getUTCFullYear() +
                    " - " +
                    ("0" + dE.getDate()).slice(-2) + "/" +
                    ("0" + (dE.getMonth() + 1)).slice(-2) + "/" +
                    dE.getUTCFullYear();

                document.getElementById("file-gambar-katalog").innerHTML = "Kosongkan jika tidak ingin diubah";
                document.getElementById("input-file-gambar-katalog").removeAttribute('required');

                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Promosi";

                var elmnt = document.getElementById("tambah-promo");
                elmnt.scrollIntoView();

                document.getElementById("loading-tabel").style.visibility = "hidden";
                document.getElementById("loading-form").style.visibility = "hidden";

            }, 1000);


            return false;
        }

        // Delete
        function hapus(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Anda yakin ingin menghapus promosi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/promosi/delete",
                        type: "POST",
                        data: {
                            id: id,
                        },
                        beforeSend: function() {
                            document.getElementById("loading-tabel").style.visibility = "visible";
                        },
                        success: function(response) {
                            console.log(response);
                            if (response['success'] == 1) {
                                document.getElementById("loading-tabel").style.visibility = "hidden";

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Promo berhasil dihapus'
                                })

                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan: '+response['message']
                                })
                            }

                        },
                        error: function(response) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan, coba lagi'
                            })
                            console.log(response.responseText);
                            document.getElementById("loading-tabel").style.visibility = "hidden";
                        },
                    });
                }
            })

            return false;
        }


    </script>
</body>

</html>

