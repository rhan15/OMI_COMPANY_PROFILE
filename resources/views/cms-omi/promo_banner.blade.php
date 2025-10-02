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
                            <h1 class="m-0 text-dark">Kelola Tipe Promo</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Tipe Promo</li>
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
                        <h3 id="form-header" class="card-title">Tambah Tipe Promo</h3>

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


                                <!-- title-->
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan judul tipe promo">
                                </div>
                                <!-- /title-->

                                <!-- Date and time range -->
                                <!-- <div class="form-group">
                                    <label>Periode</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input required type="text" class="form-control float-right" id="reservation" readonly>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="input-file-gambar">File gambar banner</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input required type="file" class="custom-file-input" id="input-file-gambar" oninvalid="setCustomValidity('Gambar wajib diisi')" onchange="try{setCustomValidity('')}catch(e){}">
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
                        <h3 class="card-title">Daftar Tipe Promo</h3>

                        <!-- <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Preview</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($promo_types))
                                @foreach ($promo_types as $promo_type)
                                    <tr id="row_{{ $promo_type['id'] }}" onclick="preview({{ json_encode($promo_type) }})">
                                        <td>{{++$i}}</td>
                                        <td>{{$promo_type['title']}}</td>
                                        <td><img src="{{ $promo_type['path_image'] }}" alt=""></td>
                                        <td onclick="event.cancelBubble=true; return false;">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" onclick="preview({{ json_encode($promo_type) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                                <button type="button" onclick="edit({{ json_encode($promo_type) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                                <button type="button" onclick="hapus(<?= $promo_type['id'] ?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
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
                                    <label class="col-sm-3 col-form-label" for="">Tipe Promo</label>
                                    <input id="preview-type" class="form-control col-sm-9" type="text" readonly value="">
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

        $(document).ready(function() {

            bsCustomFileInput.init();

            $("#table-list").DataTable({
                "pagingType": "simple_numbers",
                "aoColumnDefs": [ {
                    "bSortable": false,
                    "aTargets": [ 3 ]
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

            // let periode = document.getElementById("reservation").value;
            let tombol = document.getElementById("form-submit").innerHTML;
            let title = document.getElementById("title").value;
            let gambar = document.getElementById("input-file-gambar").value;
            let image = $('#input-file-gambar')[0].files[0];

            // let e = document.getElementById("promo_type");
            // let promo_type = e.options[e.selectedIndex].value;

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
                        form.append('gambar_banner', image);
                        form.append('title', title);
                        // form.append('periode', periode);

                        $.ajax({
                            url: "{{url('/')}}/cms/promoType/update",
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
                form.append('title', title);
                form.append('gambar_banner', image);
                // form.append('periode', periode);
                // form.append('promo_type', promo_type);

                $.ajax({
                    url: "{{url('/')}}/cms/promoType/add",
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
            document.getElementById("preview-type").value = detail.title;

            // var dS = new Date(detail.start_date);
            // var dE = new Date(detail.end_date);
            // document.getElementById("preview-date").value =
            //     ("0" + dS.getUTCDate()).slice(-2) + "/" +
            //     ("0" + (dS.getUTCMonth() + 1)).slice(-2) + "/" +
            //     dS.getUTCFullYear() +
            //     " - " +
            //     ("0" + dE.getUTCDate()).slice(-2) + "/" +
            //     ("0" + (dE.getUTCMonth() + 1)).slice(-2) + "/" +
            //     dE.getUTCFullYear();

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
                document.getElementById("file-gambar").innerHTML = "Kosongkan jika tidak ingin diubah";
                document.getElementById("input-file-gambar").removeAttribute('required');
                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Tipe Promo";

                // var dS = new Date(detail.start_date);
                // var dE = new Date(detail.end_date);
                // document.getElementById("reservation").value =
                //     ("0" + dS.getDate()).slice(-2) + "/" +
                //     ("0" + (dS.getMonth() + 1)).slice(-2) + "/" +
                //     dS.getUTCFullYear() +
                //     " - " +
                //     ("0" + dE.getDate()).slice(-2) + "/" +
                //     ("0" + (dE.getMonth() + 1)).slice(-2) + "/" +
                //     dE.getUTCFullYear();

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
                text: "Anda yakin ingin menghapus tipe promo ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/promoType/delete",
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
                                title: 'Tipe promo berhasil dihapus'
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
