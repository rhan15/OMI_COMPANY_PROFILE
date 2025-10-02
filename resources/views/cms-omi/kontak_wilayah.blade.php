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
            width: auto;
            height: 50px;
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
                            <h1 class="m-0 text-dark">Kelola Kontak Wilayah</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Kontak Wilayah</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- Form -->
            <section id="tambah-user" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Kontak Wilayah</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="userForm" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-user" type="text" hidden>

                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input  type="text" class="form-control" id="area" placeholder="Masukan area" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input  type="text" class="form-control" id="name" placeholder="Masukan full name" required> 
                                </div>

                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <input  type="text" class="form-control" id="address" placeholder="Masukan address" required>
                                </div>

                                <div class="form-group">
                                    <label for="handphone">Handphone</label>
                                    <input  type="text" class="form-control" id="handphone" placeholder="Masukan handphone"required>
                                </div>

                                <div class="form-group">
                                    <label for="whatsapp">Whatsapp</label>
                                    <input  type="text" class="form-control" id="whatsapp" placeholder="Masukan whatsapp"required>
                                </div>
                                

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input  type="text" class="form-control" id="phone" placeholder="Masukan phone" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input  type="email" class="form-control" id="email" placeholder="Masukan email" required>
                                </div>

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
            <!-- ./Form -->

            <!-- List -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar User</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Area</th>
                                    <th>Nama</th>
                                    {{-- <th>Alamat</th>
                                    <th>Handphone</th>
                                    <th>Whatsapp</th>
                                    <th>Phone</th> --}}
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($contact))
                                @foreach ($contact as $blog)
                                    <tr id="row_{{ $blog['id'] }}" onclick="preview({{ json_encode($blog) }})">
                                        <td>{{++$i}}</td>
                                        <td>{{$blog['area']}}</td>
                                        <td>{{$blog['name']}}</td>
                                        {{-- <td>{{$blog['address']}}</td>
                                        <td>{{$blog['handphone']}}</td>
                                        <td>{{$blog['whatsapp']}}</td>
                                        <td>{{$blog['phone']}}</td> --}}
                                        <td>{{$blog['email']}}</td>
                                        <td onclick="event.cancelBubble=true; return false;">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" onclick="preview({{ json_encode($blog) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                                <button type="button" onclick="edit({{ json_encode($blog) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                                <button type="button" onclick="hapus(<?= $blog['id'] ?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
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
            <!-- ./List -->
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
                                    <label class="col-sm-3 col-form-label" for="">Area</label>
                                    <input id="preview-area" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Nama</label>
                                    <input id="preview-name" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Alamat</label>
                                    <input id="preview-address" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Handphone</label>
                                    <input id="preview-handphone" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Whatsapp</label>
                                    <input id="preview-whatsapp" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Phone</label>
                                    <input id="preview-phone" class="form-control col-sm-9" type="text" readonly>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Email</label>
                                    <input id="preview-email" class="form-control col-sm-9" type="text" readonly>
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
    <!-- InputMask script -->
    <script src="{{ asset('js/input_mask/dist/jquery.inputmask.min.js')}}"></script>
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

            bsCustomFileInput.init();
        });

        // refreshForm
        function refreshForm() {
            location.reload();
        }

        // Simpan/Update Banner
        function simpan() { 
            let area = document.getElementById("area").value;
            let name = document.getElementById("name").value;
            let address = document.getElementById("address").value;
            let handphone = $("#handphone").inputmask('unmaskedvalue');
            let whatsapp = $("#whatsapp").inputmask('unmaskedvalue');
            let phone = document.getElementById("phone").value;
            let email = document.getElementById("email").value;
            let tombol = document.getElementById("form-submit").innerHTML;
            // role = 1;

            if (tombol.localeCompare('Simpan')) { //update
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Anda yakin ingin mengubah data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        let id = document.getElementById("id-user").value;
                        var form = new FormData();
                        form.append('id', id);
                        form.append('area', area);
                        form.append('name', name);
                        form.append('address', address);
                        form.append('handphone', handphone);
                        form.append('whatsapp', whatsapp);
                        form.append('phone', phone);
                        form.append('email', email);

                        $.ajax({
                            url: "{{url('/')}}/cms/kontak_wilayah/update",
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
                                        title: 'Kontak berhasil perbarui'
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
                                document.getElementById("loading-form").style.visibility = "hidden";

                            },
                            error: function(response) {
                                // console.log(response.responseText);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                })
                            },
                        });
                    }
                })
            } else { //simpan

                var form = new FormData();
                form.append('area', area);
                form.append('name', name);
                form.append('address', address);
                form.append('handphone', handphone);
                form.append('whatsapp', whatsapp);
                form.append('phone', phone);
                form.append('email', email);

                $.ajax({
                    url: "{{url('/')}}/cms/kontak_wilayah/add",
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
                                title: 'Kontak berhasil disimpan'
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
            document.getElementById("preview-area").value = detail.area;
            document.getElementById("preview-name").value = detail.name;
            document.getElementById("preview-address").value = detail.address;
            document.getElementById("preview-handphone").value = detail.handphone;
            document.getElementById("preview-whatsapp").value = detail.whatsapp;
            document.getElementById("preview-phone").value = detail.phone;
            document.getElementById("preview-email").value = detail.email;


            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";

            $("#previewModal").modal('show');
            return false;
        }

        function edit(detail) {
            document.getElementById("loading-form").style.visibility = "visible";
            document.getElementById("loading-tabel").style.visibility = "visible";

            console.log(detail);
            setTimeout(function(){
                document.getElementById("loading-tabel").style.visibility = "hidden";
                document.getElementById("loading-form").style.visibility = "hidden";

                document.getElementById("id-user").value = detail.id;
                document.getElementById("area").value = detail.area;
                document.getElementById("name").value = detail.name;
                document.getElementById("address").value = detail.address;
                document.getElementById("handphone").value = detail.handphone;
                document.getElementById("whatsapp").value = detail.whatsapp;
                document.getElementById("phone").value = detail.phone;
                document.getElementById("email").value = detail.email;
                // document.getElementById("file-gambar").innerHTML = "Kosongkan jika tidak ingin diubah";
                // document.getElementById("deskripsi").innerHTML = detail.description;
                // $('#deskripsi').summernote("code", detail.description);

                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Berita";

                var elmnt = document.getElementById("tambah-user");
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
                text: "Anda yakin ingin menghapus kontak ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/kontak_wilayah/delete",
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
                                    title: 'kontak berhasil dihapus'
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

    <script>
        $(document).ready(function($) {
            $("#whatsapp").inputmask({
                mask: "(62) #999-9999-[999999]",
                definitions: {'#': {validator: "[1-9]"}}
            });
            $("#handphone").inputmask({
                mask: "(62) #999-9999-[999999]",
                definitions: {'#': {validator: "[1-9]"}}
            });
        });
    </script>
</body>

</html>
