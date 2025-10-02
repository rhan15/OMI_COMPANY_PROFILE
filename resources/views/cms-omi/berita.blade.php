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
                            <h1 class="m-0 text-dark">Kelola Berita</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Kelola Berita</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- Form -->
            <section id="tambah-berita" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Berita</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="beritaForm" onsubmit="return simpan(event)">
                            <div class="card-body">
                                <input id="id-blog" type="text" hidden>

                                <div class="form-group">
                                    <label for="nama-file">Judul</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan judul berita">
                                </div>

                                <div class="form-group">
                                    <label for="tags">Tag Berita</label>
                                    <div class="input-group mb-3">

                                        <select id="tags" name="tags" class="select2bs4 form-control" multiple="multiple" data-placeholder="Pilih tag berita" >
                                            @if(isset($tags))
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag['id'] }}">{{ $tag['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                        <div class="input-group-append" onclick="tags()">
                                            <span class="input-group-text" data-toggle="tooltip" title="Informasi"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="file-gambar">File gambar</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="input-file-gambar" type="file" class="custom-file-input" id="input-file-gambar">
                                            <label id="file-gambar" class="custom-file-label" for="file-gambar">Pilih file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" class="textarea" placeholder="Place some text here"
                                        style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Berita Aktif</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Berita</th>
                                    <th>Tanggal</th>
                                    <th>Gambar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($blogs))
                                @foreach ($blogs as $blog)
                                    <?php
                                        $created_at = date_create($blog['created_at']);
                                    ?>
                                    <tr id="row_{{ $blog['id'] }}" onclick="preview({{ json_encode($blog) }})">
                                        <td>{{++$i}}</td>
                                        <td>{{$blog['title']}}</td>
                                        <td data-sort='{{date_format($created_at, "Ymd")}}'>{{date_format($created_at, "d/M/Y")}}</td>
                                        <td><img src="{{ $blog['path_image'] }}" alt=""></td>
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
                    <div id="loading-tabel" class="overlay loading">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
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
                                    <img id="preview-img" src="" alt="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Title</label>
                                    <input id="preview-title" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tanggal</label>
                                    <input id="preview-tanggal" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div id="preview-deskripsi" class="form-group row">

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

            <!-- Modal Tambah Tag -->
            <div class="modal fade" id="tambahTag" tabindex="-1" role="dialog" aria-labelledby="tambahTag" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Informasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <p>Untuk menambahkan tag baru yang belum ada di daftar, silahkan ketikan nama tag lalu tekan "Enter"</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Modal Tambah Tag -->

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

        $(document).ready(function() {
            bsCustomFileInput.init();

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

            $('#deskripsi').summernote({
                height: 300
            });

            //Initialize Select2 Elements
            // $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                tags: true,
                createTag: function (params) {
                    return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                    }
                }
            });
        });

        // Toast setting
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function tags(){
            $("#tambahTag").modal('show');
            return false;
        }

        // refreshForm
        function refreshForm() {
            location.reload();
        }

        // Simpan/Update Banner
        function simpan() {
            let title = document.getElementById("title").value;
            let gambar = document.getElementById("file-gambar").value;
            let deskripsi = $('#deskripsi').summernote('code');
            let tombol = document.getElementById("form-submit").innerHTML;
            let tags = $("#tags").select2("val");

            if ($('#deskripsi').summernote('isEmpty')){
                // alert('Deskripsi tidak boleh kosong');
                Toast.fire({
                    icon: 'error',
                    title: 'Deskripsi tidak boleh kosong'
                });
                return false;
            }

            // let tags = e.options[e.selectedIndex].value;

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
                        let id = document.getElementById("id-blog").value;
                        var image = $('#input-file-gambar')[0].files[0];

                        var form = new FormData();
                        form.append('id', id);
                        form.append('gambar', image);
                        form.append('title', title);
                        form.append('tags', tags);
                        form.append('description', deskripsi);

                        $.ajax({
                            url: "{{url('/')}}/cms/blog/update",
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
                                        title: 'Berita berhasil perbarui'
                                    })

                                    setTimeout(function(){
                                        location.reload();
                                    }, 2000);
                                } else if(response['success'] == 3){
                                    document.getElementById("input-file-gambar").classList.add("is-invalid");
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['message']
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Terjadi kesalahan: '+response['message']
                                    })
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
                })
            } else { //simpan
                var image = $('#input-file-gambar')[0].files[0];

                var form = new FormData();
                form.append('gambar', image);
                form.append('tags', tags);
                form.append('title', title);
                form.append('description', deskripsi);
                // return false;
                $.ajax({
                    url: "{{url('/')}}/cms/blog/add",
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
                                title: 'Berita berhasil disimpan'
                            });

                            setTimeout(function(){
                                location.reload();
                            }, 2000);

                        } else if(response['success'] == 3){
                                document.getElementById("input-file-gambar").classList.add("is-invalid");
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
                        })
                    },
                });
            }
            return false;
        }

        // Preview
        function preview(detail) {
            console.log(detail);
            document.getElementById("preview-img").src = detail.path_image;
            document.getElementById("preview-title").value = detail.title;
            document.getElementById("preview-deskripsi").innerHTML = detail.description;

            // var selectedValuesTest = ["WY", "AL", "NY"];
            // $("#e1").select2({
            //     multiple: true,
            // });
            // $('#e1').val(selectedValuesTest).trigger('change');

            var date = new Date(detail.created_at);
            document.getElementById("preview-tanggal").value =
                ("0" + date.getUTCDate()).slice(-2) + "/" +
                ("0" + (date.getUTCMonth() + 1)).slice(-2) + "/" +
                date.getUTCFullYear();

            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";

            $("#previewModal").modal('show');
            return false;
        }

        function edit(detail) {

            document.getElementById("loading-form").style.visibility = "visible";
            document.getElementById("loading-tabel").style.visibility = "visible";

            setTimeout(function(){
                document.getElementById("id-blog").value = detail.id;
                document.getElementById("title").value = detail.title;
                document.getElementById("title").value = detail.title;
                document.getElementById("file-gambar").innerHTML = "Kosongkan jika tidak ingin diubah";
                document.getElementById("input-file-gambar").removeAttribute('required');

                document.getElementById("deskripsi").innerHTML = detail.description;
                $('#deskripsi').summernote("code", detail.description);

                if (detail.tags != null) {
                    let tags = detail.tags.split(",");
                    $('#tags').val(tags).trigger('change');
                }else {
                    $('#tags').val([]).trigger('change');
                }

                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Berita";


                document.getElementById("loading-tabel").style.visibility = "hidden";
                document.getElementById("loading-form").style.visibility = "hidden";

            }, 1000);
                var elmnt = document.getElementById("tambah-berita");
                elmnt.scrollIntoView();

            return false;
        }

        // Delete
        function hapus(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Anda yakin ingin menghapus berita ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/blog/delete",
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

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Berita berhasil dihapus'
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
</body>

</html>
