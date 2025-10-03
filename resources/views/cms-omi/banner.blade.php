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

    <!-- Style -->
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

        #preview-img {
            margin-left: auto;
            margin-right: auto;
            max-height: 300px;
            max-width: 100%;
        }
    </style>
    <!-- /Style -->

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
                            <h1 class="m-0 text-dark">Kelola Banner</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Banner</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <!-- form -->
            <section id="tambah-banner" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Banner</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="bannerForm" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-banner" type="text" hidden>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan title" oninvalid="this.setCustomValidity('Title wajib diisi!')" oninput="this.setCustomValidity('')">
                                </div>

                                <div class="form-group">
                                    <label for="tautan">Tautan</label>
                                    <input type="text" class="form-control" id="tautan"
                                        placeholder="Kosongkan jika tidak ada"
                                        pattern="https?://.*" oninvalid="setValidasi()"
                                        onchange="validasi()">
                                </div>

                                <div id="isnewtab-form" class="form-group">
                                    <label for="tautan">Buka tautan di tab baru?</label>
                                    <select name="" id="isnewtab" class="form-control" disabled="true">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="tautan" placeholder="Kosongkan jika tidak ada" pattern="https?://.*" oninvalid="setCustomValidity('Format url tidak sesuai(contoh:Format: https://..)')" onchange="try{setCustomValidity('')}catch(e){}"> -->
                                </div>

                                <!-- Date and time range -->
                                <div class="form-group">
                                    <label>Masa Berlaku</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input required type="text" class="form-control float-right" id="reservation" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="input-file-gambar">File gambar</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input required="required" type="file" class="custom-file-input" id="input-file-gambar" oninvalid="setCustomValidity('Gambar wajib diisi')" onchange="try{setCustomValidity('')}catch(e){}">
                                            <label id="file-gambar" class="custom-file-label" for="input-file-gambar">Pilih file</label>
                                        </div>
                                        <!-- <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div> -->
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button id="form-submit" class="btn btn-primary" href="" type="submit">Simpan</button>
                                <a class="btn btn-default float-right" href="" onclick="refreshForm()" role="button">Batal</a>
                                <!-- <button id="form-batal" class="btn btn-default float-right">Batal</button> -->
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
                        <h3 class="card-title">Daftar Banner</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Periode</th>
                                    <th>Preview</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($banners))
                                @foreach ($banners as $banner)
                                <?php
                                $start_date = date_create($banner['start_date']);
                                $end_date = date_create($banner['end_date']);
                                $date_now = \Carbon\Carbon::now();
                                $outdated = true;
                                if ($start_date <= $date_now && $end_date >= $date_now) {
                                    $outdated = false;
                                }
                                    
                                $outdated_message = "";
                                if ($start_date > $date_now) {
                                    $outdated_message = "Banner belum berlaku";
                                } else if ($end_date < $date_now) {
                                    $outdated_message = "Banner sudah lewat";
                                }
                                ?>
                                <tr id="row_{{ $banner['id'] }}" onclick="preview({{ json_encode($banner) }})" <?php if($outdated){?>data-toggle="tooltip" title="{{$outdated_message}}"<?php } ?>>
                                    <td>{{++$i}}</td>
                                    <td>{{$banner['title']}}</td>
                                    <td data-sort='{{date_format($start_date, "Ymd")}}' <?php if ($outdated) { ?>style="color:#dc3545" <?php } ?>>{{ date_format($start_date, "d/M/Y") }} - {{ date_format($end_date, "d/M/Y") }}</td>
                                    <td><img src="{{ $banner['path_image'] }}" alt=""></td>
                                    <td onclick="event.cancelBubble=true; return false;">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" onclick="preview({{ json_encode($banner) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                            <button type="button" onclick="edit({{ json_encode($banner) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                            <button type="button" onclick="hapus(<?= $banner['id'] ?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div id="loading-tabel" class="overlay loading">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>

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
                                    <img id="preview-img" src="" alt="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Title</label>
                                    <input id="preview-title" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tautan</label>
                                    <input id="preview-tautan" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Masa Berlaku</label>
                                    <input id="preview-date" class="form-control col-sm-9" type="text" readonly value="">
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
    <!-- DataTables -->
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- page script -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toast setting
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function setValidasi(){
            if (document.getElementById("tautan").value != null) {
                document.getElementById("tautan").setCustomValidity('Format url tidak sesuai(contoh:Format: https://..)');
                Toast.fire({
                    icon: 'error',
                    title: 'Format url tidak sesuai(contoh:Format: https://..)'
                });
            }
            // document.getElementById("isnewtab-form").style.display = "none";
            document.getElementById("isnewtab").disabled = true;
        }

        function validasi(){
            try{
                setCustomValidity('')
            }catch(e){}

            console.log('cek');
            document.getElementById("isnewtab").disabled = false;
            // document.getElementById("isnewtab-form").style.display = "block";

        }

        $(document).ready(function() {
            $("#table-list").DataTable({
                "pagingType": "simple_numbers",
                "aoColumnDefs": [ {
                    "bSortable": false,
                    "aTargets": [ 3, 4 ]
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

            bsCustomFileInput.init();

        });

        $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // refreshForm
        function refreshForm() {
            location.reload();
        }

        // Simpan/Update Banner
        function simpan() {

            let title = document.getElementById("title").value;
            let tautan = document.getElementById("tautan").value;

            let isnewtab = null;
            if (tautan != null) {
                isnewtab = document.getElementById("isnewtab").value;
            }

            let masaberlaku = document.getElementById("reservation").value;
            let tombol = document.getElementById("form-submit").innerHTML;
            let gambar = document.getElementById("input-file-gambar").value;
            var image = $('#input-file-gambar')[0].files[0];

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
                        let id = document.getElementById("id-banner").value;

                        var form = new FormData();
                        form.append('id', id);
                        form.append('gambar', image);
                        form.append('title', title);
                        form.append('tautan', tautan);
                        form.append('isnewtab', isnewtab);
                        form.append('masaberlaku', masaberlaku);


                        $.ajax({
                            url: "{{url('/')}}/cms/banner/update",
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
                                        title: 'Banner berhasil diperbarui'
                                    });

                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);

                                } else if (response['success'] == 3) {
                                    document.getElementById("input-file-gambar").classList.add("is-invalid");
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['message']
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['message']
                                    });
                                }
                            },
                            error: function(response) {
                                console.log(response.responseText);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                });
                            },
                        });
                    }
                })
            } else { //simpan
                var form = new FormData();
                form.append('gambar', image);
                form.append('title', title);
                form.append('tautan', tautan);
                form.append('isnewtab', isnewtab);
                form.append('masaberlaku', masaberlaku);

                $.ajax({
                    url: "{{url('/')}}/cms/banner/add",
                    type: "POST",
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        document.getElementById("loading-form").style.visibility = "visible";
                    },
                    success: function(response) {
                        console.log(response);
                        if (response['success'] == 1) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Banner berhasil disimpan'
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        } else if (response['success'] == 3) {
                            document.getElementById("input-file-gambar").classList.add("is-invalid");
                            Toast.fire({
                                icon: 'error',
                                title: response['message']
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response['message']
                            });
                        }

                        document.getElementById("loading-form").style.visibility = "hidden";

                    },
                    error: function(response) {
                        console.log(response.responseText);
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

            document.getElementById("preview-img").src = detail.path_image;
            document.getElementById("preview-title").value = detail.title;
            document.getElementById("preview-tautan").value = detail.onclick_url;

            // document.getElementById("input-file-gambar").value = detail.path_image;
            // document.getElementById("submit").innerHTML = "Perbarui";
            // document.getElementById("form-header").innerHTML = "Edit Banner";

            var dS = new Date(detail.start_date);
            var dE = new Date(detail.end_date);
            document.getElementById("preview-date").value =
                ("0" + dS.getUTCDate()).slice(-2) + "/" +
                ("0" + (dS.getUTCMonth() + 1)).slice(-2) + "/" +
                dS.getUTCFullYear() +
                " - " +
                ("0" + dE.getUTCDate()).slice(-2) + "/" +
                ("0" + (dE.getUTCMonth() + 1)).slice(-2) + "/" +
                dE.getUTCFullYear();

            // var elmnt = document.getElementById("tambah-banner");
            // elmnt.scrollIntoView();

            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";

            $("#previewModal").modal('show');
            return false;
        }

        // Edit
        function edit(detail) {
            // let detail = response.banner[0];
            document.getElementById("loading-form").style.visibility = "visible";
            document.getElementById("loading-tabel").style.visibility = "visible";

            setTimeout(function() {
                document.getElementById("id-banner").value = detail.id;
                document.getElementById("title").value = detail.title;
                document.getElementById("tautan").value = detail.onclick_url;

                if (detail.onclick_url != null) {
                    document.getElementById("isnewtab").disabled = false;
                    if (detail.is_newtab == 1) {
                        document.getElementById("isnewtab").value = 1;
                    }else{
                        document.getElementById("isnewtab").value = 0;
                    }
                } else {
                    document.getElementById("isnewtab").disabled = true;
                }

                document.getElementById("file-gambar").innerHTML = "Kosongkan jika tidak ingin diubah";
                document.getElementById("input-file-gambar").removeAttribute('required');
                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Banner";

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

                var elmnt = document.getElementById("tambah-banner");
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
                text: "Anda yakin ingin menghapus banner ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/banner/delete",
                        type: "POST",
                        data: {
                            id: id,
                        },
                        beforeSend: function() {
                            document.getElementById("loading-tabel").style.visibility = "visible";
                        },
                        success: function(response) {
                            console.log(response);
                            document.getElementById("loading-tabel").style.visibility = "hidden";

                            Toast.fire({
                                icon: 'success',
                                title: 'Banner berhasil dihapus'
                            })

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
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
