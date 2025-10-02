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

        .ellipsis {
            max-width: 75px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 15px;
            color: red;
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
                            <h1 class="m-0 text-dark">Kelola Kisah Sukses</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Kisah Sukses</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <!-- form -->
            <section id="tambah-kisah" class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 id="form-header" class="card-title">Tambah Kisah Sukses</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="testimonialsForm" onsubmit="return simpan(event)">
                            <div class="card-body">

                                <input id="id-kisah" type="text" hidden>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input required type="text" class="form-control" id="title" placeholder="Masukan title" oninvalid="this.setCustomValidity('Title wajib diisi!')" oninput="this.setCustomValidity('')">
                                </div>
                                <div id="isvideo-form" class="form-group">
                                    <label for="isvideo">Jenis file</label>
                                    <select name="" id="isvideo" class="form-control" onchange="openLinkform()">
                                        <option value="1">Video</option>
                                        <option value="0">Gambar</option>
                                    </select>
                                </div>

                                <div id="link-video" class="form-group" style="display: block">
                                    <label for="tautan">Tautan</label>
                                    <input type="text" class="form-control" id="tautan"
                                        placeholder="Kosongkan jika tidak ada" pattern="^https?://(www\.)?youtube\.com\/(embed)\/.+$"
                                        oninvalid="setCustomValidity('Format url : https:/ /www.youtube.com/embed/..)');setValidasi()" oninput="setCustomValidity('')" onchange="validasi()">
                                </div>
                                
                                <div id="link-gambar" class="form-group" style="display: none;">
                                    <label for="input-file-gambar">File gambar</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="input-file-gambar" oninvalid="setCustomValidity('Gambar wajib diisi')" onchange="try{setCustomValidity('')}catch(e){}">
                                            <label id="file-gambar" class="custom-file-label" for="input-file-gambar">Pilih file</label>
                                        </div>
                                    </div>
                                    <div class="info">Jenis file yang didukung jpg/jpeg/png</div>
                                </div>

                                <div id="flagdefault-form" class="form-group" style="display: block;">
                                    <label for="flagdefault">Tampilkan di beranda?</label>
                                    <select name="" id="flagdefault" class="form-control" disabled="true">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
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
            <!--/. form -->

            <!-- list -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Kisah Sukses</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Tautan</th>
                                    <th>Jenis File</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($testimonials))
                                @foreach ($testimonials as $blog)
                                    <tr id="row_{{ $blog['id'] }}" onclick="preview({{ json_encode($blog) }})">
                                        <td>{{++$i}}</td>
                                        <td>{{$blog['title']}}</td>
                                        <td class="ellipsis">
                                            @if ($blog['is_video']==1)
                                                {{$blog['url']}}
                                            @else
                                                <img src="{{$blog['url']}}" alt="">
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if ($blog['is_video']==1)
                                                Video
                                            @else
                                                Gambar
                                            @endif
                                        </td>
                                        <td class="ellipsis">{{$blog['description']}}</td>
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
                                <div class="form-group row d-flex justify-content-center" id="preview-gmb">
                                        <iframe id="videoUrl-preview" style="display: none" class="item-video" width="600px" height="300px" src=""></iframe>
                                        <img id="imgUrl-preview" style="display: none; max-width: 100%;" class="item-video" src="" alt="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Title</label>
                                    <input id="preview-title" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tautan</label>
                                    <input id="preview-url" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Jenis File</label>
                                    <input id="preview-isvideo" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Description</label>
                                    <textarea id="preview-description" class="form-control col-sm-9" cols="30" rows="8" readonly value=""></textarea>
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
    {{-- <script src="{{ asset('js/inputmask/dist/jquery.inputmask.js')}}"></script> --}}

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
                // document.getElementById("tautan").setCustomValidity('Format url : https://www.youtube.com/embed/..)');
                Toast.fire({
                    icon: 'error',
                    title: 'Format url : https://www.youtube.com/embed/..)'
                });
            }
            document.getElementById("flagdefault").disabled = true;
        }

        function validasi(){
            try{
                setCustomValidity('')
            }catch(e){}
            document.getElementById("flagdefault").disabled = false;
        }

        $('#deskripsi').summernote({
            height: 300
        });

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

        // refreshForm
        function refreshForm() {
            location.reload();
        }

        // Simpan/Update Kisah Sukses
        function simpan() {

            let title = document.getElementById("title").value;
            let isvideo = document.getElementById("isvideo").value;
            let tautan = document.getElementById("tautan").value;
            let flagdefault = document.getElementById("flagdefault").value;
            let deskripsi = $('#deskripsi').summernote('code');
            console.log(tautan);

            if ($('#deskripsi').summernote('isEmpty')){
                // alert('Deskripsi tidak boleh kosong');
                Toast.fire({
                    icon: 'error',
                    title: 'Deskripsi tidak boleh kosong'
                });
                return false;
            }

            let tombol = document.getElementById("form-submit").innerHTML;
            // let gambar = document.getElementById("input-file-gambar").value;
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
                        let id = document.getElementById("id-kisah").value;

                        var form = new FormData();
                        form.append('id', id);
                        form.append('gambar', image);
                        form.append('title', title);
                        form.append('tautan', tautan);
                        form.append('isvideo', isvideo);
                        form.append('flagdefault', flagdefault);
                        form.append('description', deskripsi);

                        $.ajax({
                            url: "{{url('/')}}/cms/kisah_sukses/update",
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
                                        title: 'Kisah sukses berhasil diperbarui'
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
                                // console.log(response.responseText);
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
                form.append('isvideo', isvideo);
                form.append('flagdefault', flagdefault);
                form.append('description', deskripsi);
                $.ajax({
                    url: "{{url('/')}}/cms/kisah_sukses/add",
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
                        if (response['success'] == 1) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Kisah sukses berhasil disimpan'
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
                        // console.log(response.responseText);
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
            var file = "";
            if ( detail.is_video == 1) {
                file = "Video";
                document.getElementById('imgUrl-preview').style.display = 'none';
                document.getElementById('videoUrl-preview').style.display = 'block';
                document.getElementById("videoUrl-preview").src = detail.url;
            } else {
                file = "Gambar";
                document.getElementById('videoUrl-preview').style.display = 'none';
                document.getElementById('imgUrl-preview').style.display = 'block';
                document.getElementById("imgUrl-preview").src = detail.url;
            }

            document.getElementById("preview-title").value = detail.title;
            document.getElementById("preview-url").value = detail.url;
            document.getElementById("preview-description").value = detail.description;
            document.getElementById("preview-isvideo").value = file;
            document.getElementById("loading-tabel").style.visibility = "hidden";
            document.getElementById("loading-form").style.visibility = "hidden";

            $("#previewModal").modal('show');
            return false;
        }

        // Edit
        function edit(detail) {
            document.getElementById("loading-form").style.visibility = "visible";
            document.getElementById("loading-tabel").style.visibility = "visible";
            document.getElementById("isvideo").disabled = true; 
            document.getElementById("flagdefault").disabled = false;

            setTimeout(function() {
                document.getElementById("id-kisah").value = detail.id;
                document.getElementById("title").value = detail.title;
                document.getElementById("isvideo").value = detail.is_video;
                // console.log(detail.is_video);

                if (detail.is_video == 1) {
                    document.getElementById("isvideo").value = 1;
                    openLinkform();
                    document.getElementById("tautan").value = detail.url;
                }else{
                    document.getElementById("isvideo").value = 0; 
                    openLinkform();
                    document.getElementById("file-gambar").innerHTML = "Kosongkan jika tidak ingin diubah";
                    document.getElementById("input-file-gambar").removeAttribute('required');
                } 

                document.getElementById("deskripsi").innerHTML = detail.description;
                $('#deskripsi').summernote("code", detail.description);

                document.getElementById("form-submit").innerHTML = "Perbarui";
                document.getElementById("form-header").innerHTML = "Edit Kisah";

                var elmnt = document.getElementById("tambah-kisah");
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
                text: "Anda yakin ingin kisah ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{url('/')}}/cms/kisah_sukses/delete",
                        type: "POST",
                        data: {
                            id: id,
                        },
                        beforeSend: function() {
                            document.getElementById("loading-tabel").style.visibility = "visible";
                        },
                        success: function(response) {
                            // console.log(response);
                            document.getElementById("loading-tabel").style.visibility = "hidden";

                            Toast.fire({
                                icon: 'success',
                                title: 'Kisah sukses berhasil dihapus'
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
                            // console.log(responseponseText);
                            document.getElementById("loading-tabel").style.visibility = "hidden";
                        },
                    });
                }
            })
            return false;
        }

        function openLinkform() {
        var id = document.getElementById("isvideo").value;
        if (id ==1) {
            document.getElementById('link-video').style.display = 'block';
            document.getElementById('flagdefault-form').style.display = 'block';
            document.getElementById('link-gambar').style.display = 'none';
        }else{
            document.getElementById('link-video').style.display = 'none';
            document.getElementById('flagdefault-form').style.display = 'none';
            document.getElementById('link-gambar').style.display = 'block';
        }
    }
    </script>
</body>

</html>
