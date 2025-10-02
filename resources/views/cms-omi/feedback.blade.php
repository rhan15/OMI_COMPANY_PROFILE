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

        .content-table {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
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
                            <h1 class="m-0 text-dark">Daftar Feedback</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Daftar Feedback</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <!-- form -->
            {{--
            <section id="tambah-banner" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Banner</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="bannerForm" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-banner" type="text" hidden>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan title">
                                </div>

                                <div class="form-group">
                                    <label for="tautan">Tautan</label>
                                    <input type="text" class="form-control" id="tautan" placeholder="Kosongkan jika tidak ada (format: https://...)">
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
                                            <input required type="file" class="custom-file-input" id="input-file-gambar">
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
            --}}
            <!--/. form -->

            <!-- list -->
            <section class="content">
                <div class="card">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Daftar Feedback</h3>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table  id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Tanggal</th>
                                    <th>Konten</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($feedbacks))
                                @foreach ($feedbacks as $feedback)
                                <?php
                                    $created_at = date_create($feedback['created_at']);
                                ?>
                                <tr id="row_{{ $feedback['id'] }}" onclick="preview({{ json_encode($feedback) }})">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $feedback['user_name'] }}</td>
                                    <td>{{ $feedback['email'] }}</td>
                                    <td data-sort='{{date_format($created_at, "Ymd")}}'>{{ date_format($created_at, "d/M/Y") }}</td>
                                    <td class="content-table">{{ $feedback['content'] }}</td>
                                    <td onclick="event.cancelBubble=true; return false;">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" onclick="preview({{ json_encode($feedback) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                            <!-- <button type="button" onclick="edit({{ json_encode($feedback) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button> -->
                                            <?php if ($feedback['is_sent'] == null || $feedback['is_sent'] == 0) {
                                            ?>
                                                <button type="button" onclick="send({{ json_encode($feedback) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="resend"><i class="fas fa-paper-plane"></i></button>
                                            <?php }else{ ?>
                                                <button type="button" class="btn disabled btn-secondary" data-toggle="tooltip" data-placement="top" title="resend"><i class="fas fa-paper-plane"></i></button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

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
                                    <label class="col-sm-3 col-form-label" for="">Nama</label>
                                    <input id="preview-username" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Email</label>
                                    <input id="preview-email" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">No Hp</label>
                                    <input id="preview-numberPhone" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tanggal</label>
                                    <input id="preview-date" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Pesan</label>
                                    <textarea id="preview-content" class="form-control col-sm-9" name="" id="" cols="30" rows="10" readonly></textarea>
                                    <!-- <input id="preview-content" class="form-control col-sm-9" type="text" readonly value=""> -->
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

            // $.fn.DataTable.ext.pager.numbers_length = 5;

            $("#table-list").DataTable({
                "pagingType": "simple_numbers",
                "aoColumnDefs": [ {
                    "bSortable": false,
                    "aTargets": [ 5 ]
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

        var _URL = window.URL || window.webkitURL;

        // Preview
        function preview(detail) {
            document.getElementById("preview-username").value = detail.user_name;
            document.getElementById("preview-email").value = detail.email;
            document.getElementById("preview-numberPhone").value = detail.phone;
            document.getElementById("preview-content").innerHTML = detail.content;

            var date = new Date(detail.created_at);
            document.getElementById("preview-date").value =
                ("0" + date.getUTCDate()).slice(-2) + "/" +
                ("0" + (date.getUTCMonth() + 1)).slice(-2) + "/" +
                date.getUTCFullYear();

            document.getElementById("loading-tabel").style.visibility = "hidden";

            $("#previewModal").modal('show');
            return false;
        }

        function send(detail) {
            console.log(detail);
            var form = new FormData();
            form.append('id', detail['id']);
            form.append('email', detail['email']);
            form.append('phone', detail['phone']);
            form.append('user_name', detail['user_name']);
            form.append('province', detail['province']);
            form.append('content', detail['content']);

            // return false;

            $.ajax({
                url: "{{url('/')}}/cms/feedback/send",
                type: "POST",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    document.getElementById("loading-tabel").style.visibility = "visible";
                },
                success: function(response) {
                    console.log(response);
                    if (response['success'] == 1) {
                        Toast.fire({
                            icon: 'success',
                            title: 'feedback berhasil dikirim'
                        });

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
                    console.log(response.responseText);
                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan coba lagi'
                    });
                },
            });
        }
    </script>

</body>

</html>
