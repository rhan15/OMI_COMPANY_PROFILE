<!DOCTYPE html>
<html>

<head>
    <!-- Head -->
    @include('cms-omi.template.head')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- /Head -->

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

        #cabang_image {
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
                            <h1 class="m-0 text-dark">Kelola Toko</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Kelola Toko</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <section id="tambah-cabang" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Toko</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-toko" type="text" hidden>

                                <div class="form-group">
                                    <label for="shop-name">Nama Toko</label>
                                    <input required="required" type="text" class="form-control" id="shop-name" placeholder="Masukan nama toko">
                                </div>

                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select id="branch-id" name="cabang" class="form-control">
                                        @if(isset($branches))
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch['id']}}">{{$branch['branch_name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="long">Longitude</label>
                                    <input step="any" required type="number" class="form-control" id="long" placeholder="Masukan titik longitude">
                                </div>

                                <div class="form-group">
                                    <label for="lat">Latitude</label>
                                    <input step="any" required type="number" class="form-control" id="lat" placeholder="Masukan titik latitude">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea id="alamat" class="form-control" placeholder="Masukan alamat lengkap"
                                        style="width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Toko</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Toko</th>
                                    <th>Cabang</th>
                                    <th>Alamat</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($shops))
                                @foreach ($shops as $shop)
                                    <tr style="cursor: pointer;" onclick="preview({{$shop}})">
                                        <td >{{++$i}}</td>
                                        <td>{{$shop['shop_name']}}</td>
                                        <td>{{$shop['branch_name']}}</td>
                                        <td>{{$shop['address'] ?? '-'}}</td>
                                        <td style="min-width: 150px;cursor:default;" onclick="event.cancelBubble=true;return false;">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" onclick="showDetail({{ $shop }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                                <button type="button" onclick="edit({{ $shop }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button>
                                                <button type="button" onclick="hapus({{ $shop }})" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></button>
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
                                    <label class="col-sm-3 col-form-label" for="">Nama Toko</label>
                                    <input id="preview-shop-name" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Cabang</label>
                                    <input id="preview-branch-name" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Longitude</label>
                                    <input id="preview-long" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Latitude</label>
                                    <input id="preview-lat" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <textarea id="preview-alamat" class="form-control col-sm-9" placeholder="Masukan alamat lengkap"
                                        style="width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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

    {{-- Modal --}}
    {{--@include('cms-omi.template.modal_branchdetail')--}}

</body>

</html>
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

    function refreshForm() {
        location.reload();
    }

    function simpan() {

        let shop_name = document.getElementById("shop-name").value;
        let branch_id = document.getElementById("branch-id").value;
        let longitude = document.getElementById("long").value;
        let latitude = document.getElementById("lat").value;
        let address = document.getElementById("alamat").value;

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
                    let id = document.getElementById("id-toko").value;

                    var form = new FormData();
                    form.append('id', id);
                    form.append('shop_name', shop_name);
                    form.append('branch_id', branch_id);
                    form.append('longitude', longitude);
                    form.append('latitude', latitude);
                    form.append('address', address);

                    $.ajax({
                        url: "{{url('/')}}/cms/toko/update",
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
                                    title: 'Toko berhasil diperbarui'
                                });

                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else if(response['success'] == 2){
                                Toast.fire({
                                    icon: 'error',
                                    title: response['message']
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
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
            form.append('shop_name', shop_name);
            form.append('branch_id', branch_id);
            form.append('longitude', longitude);
            form.append('latitude', latitude);
            form.append('address', address);

            $.ajax({
                url: "{{url('/')}}/cms/toko/add",
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
                            title: 'Toko berhasil disimpan'
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else if(response['success'] == 2){
                        Toast.fire({
                            icon: 'error',
                            title: response['message']
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan coba lagi'
                        });
                        console.log(response['message']);
                    }
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

        document.getElementById("preview-shop-name").value = detail.shop_name;
        document.getElementById("preview-branch-name").value = detail.branch_name;
        document.getElementById("preview-long").value = detail.longitude;
        document.getElementById("preview-lat").value = detail.latitude;
        document.getElementById("preview-alamat").value = detail.address;


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

            document.getElementById("id-toko").value = detail.id;
            document.getElementById("shop-name").value = detail.shop_name;
            document.getElementById("branch-id").value = detail.branch_id;
            document.getElementById("long").value = detail.longitude;
            document.getElementById("lat").value = detail.latitude;
            document.getElementById("alamat").value = detail.address;

            document.getElementById("form-submit").innerHTML = "Perbarui";
            document.getElementById("form-header").innerHTML = "Edit Cabang";

            var elmnt = document.getElementById("tambah-cabang");
            elmnt.scrollIntoView();

            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";
        }, 1000);

        return false;
    }

    function hapus(cbn){
        Swal.fire({
                title: 'Konfirmasi hapus data',
                text: "Anda yakin ingin menghapus toko "+cbn['shop_name']+" ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/toko/delete",
                        type: "POST",
                        data: {
                            id: cbn['id'],
                        },
                        beforeSend: function() {
                            document.getElementById("loading-tabel").style.visibility = "visible";
                        },
                        success: function(response) {
                            console.log(response);
                            if (response['success'] == 1) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Toko berhasil dihapus'
                                })

                                setTimeout(function(){
                                    location.reload();
                                }, 2000);

                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                });
                            }
                            document.getElementById("loading-tabel").style.visibility = "hidden";
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
