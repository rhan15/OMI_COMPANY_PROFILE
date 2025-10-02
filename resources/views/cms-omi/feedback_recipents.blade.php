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
                            <h1 class="m-0 text-dark">Kelola Email Penerima</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/cms">Home</a></li>
                                <li class="breadcrumb-item active">Kelola Email Penerima</li>
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
                        <h3 id="form-header" class="card-title">Tambah Email</h3>
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

                                <input id="id-email" type="text" hidden>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input  type="email" class="form-control" id="email" placeholder="Masukan email">
                                </div>

                                <div class="form-group">
                                    <label for="flags">Flag</label>
                                    <div class="input-group mb-3">
                                        <select id="flags" name="flags" class="select2bs4 form-control" multiple="multiple" data-placeholder="Pilih tag berita" >
                                            <option value="1">Feedback</option>
                                            <option value="2">Register</option>
                                        </select>
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
                        <h3 class="card-title">Daftar Email Aktif</h3>

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
                                    <th>email</th>
                                    <th>Flag</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($recipents))
                                @foreach ($recipents as $recipent)
                                <?php
                                    $flag = "";

                                    if ($recipent['flag_feedback'] == 1) {
                                        $flag = $flag." feedback";
                                    }

                                    if ($recipent['flag_register'] == 1) {
                                        if ($flag == "") {
                                            $flag = $flag."register";
                                        }else{
                                            $flag = $flag.", register";
                                        }
                                    }

                                ?>
                                <tr  id="row_{{ $recipent['id'] }}" onclick="preview({{ json_encode($recipent) }})" data-toggle="tooltip" title="Outdated">
                                    <td>{{++$i}}</td>
                                    <td>{{$recipent['email']}}</td>
                                    <td>{{$flag}}</td>
                                    <td onclick="event.cancelBubble=true; return false;">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" onclick="preview({{ json_encode($recipent) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                            <button type="button" onclick="edit({{ json_encode($recipent) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                            <button type="button" onclick="hapus(<?= $recipent['id'] ?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
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
                                    <label class="col-sm-3 col-form-label" for="">Email</label>
                                    <input id="preview-email" class="form-control col-sm-9" type="email" readonly>
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
            $("#table-list").DataTable({
                "pagingType": "simple_numbers",
                "aoColumnDefs": [ {
                    "bSortable": false,
                    "aTargets": [ 2 ]
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

            $('.select2bs4').select2({
                theme: 'bootstrap4',
                tags: true,
                createTag: function (params) {
                    return {
                    id: params.term,
                    text: params.term,
                    newOption: false
                    }
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

        var _URL = window.URL || window.webkitURL;

        // Simpan/Update Email
        function simpan() {

            let email = document.getElementById("email").value;
            let flags = $("#flags").select2("val");
            let tombol = document.getElementById("form-submit").innerHTML;

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
                        let id = document.getElementById("id-email").value;

                        var form = new FormData();
                        form.append('id', id);
                        form.append('email', email);
                        form.append('flags', flags);

                        $.ajax({
                            url: "{{url('/')}}/cms/recipent/update",
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
                                document.getElementById("loading-form").style.visibility = "hidden";
                                if (response['success'] == 1) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Email berhasil diperbarui'
                                    });

                                    setTimeout(function(){
                                        location.reload();
                                    }, 2000);
                                }else{
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
                form.append('email', email);
                form.append('flags', flags);

                $.ajax({
                    url: "{{url('/')}}/cms/recipent/add",
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
                                title: 'Email berhasil disimpan'
                            });

                            setTimeout(function(){
                                location.reload();
                            }, 2000);

                        }else if(response['success'] == 3){
                            document.getElementById("input-file-gambar").classList.add("is-invalid");
                            Toast.fire({
                                icon: 'error',
                                title: response['message']
                            });
                        }else{
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

            document.getElementById("preview-email").value = detail.email;

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

            setTimeout(function(){
                document.getElementById("id-email").value = detail.id;
                document.getElementById("email").value = detail.email;

                if (detail.flag_feedback != null || detail.flag_register != null) {
                    let flag=[];

                    if (detail.flag_feedback == 1) {
                        flag.push("1");
                    }
                    if (detail.flag_register == 1) {
                        flag.push("2");
                    }

                    $('#flags').val(flag).trigger('change');
                }else {
                    $('#flags').val([]).trigger('change');
                }

                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Email";

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
                text: "Anda yakin ingin menghapus Email ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/recipent/delete",
                        type: "POST",
                        data: {
                            id: id,
                        },
                        beforeSend: function() {
                            document.getElementById("loading-tabel").style.visibility = "visible";
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response['success'] == 1){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Email berhasil dihapus'
                                })

                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: response['message']
                                });
                            }

                            document.getElementById("loading-tabel").style.visibility = "hidden";
                        },
                        error: function(response) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan, coba lagi'
                            })
                            // console.log(response.responseText);
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
