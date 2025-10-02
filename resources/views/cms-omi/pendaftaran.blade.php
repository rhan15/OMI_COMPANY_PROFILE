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
                            <h1 class="m-0 text-dark">Daftar Pendaftar</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                                <li class="breadcrumb-item active">Daftar Pendaftar</li>
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
                        <h3 id="form-header" class="card-title">Filter Data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- <form id="bannerForm" onsubmit="return cetak(event)"> -->
                            <div class="card-body">

                                <!-- <div id="isall-form" class="form-group">
                                    <select name="" id="isall" class="form-control" onchange="isalll()">  
                                        <option value="0">Cetak Sebagian</option>
                                        <option value="1">Cetak Semua</option>
                                    </select>
                                </div> -->

                                <!-- Date and time range -->
                                <div class="form-group">
                                    <label>Pilih Tanggal</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input required type="text" class="form-control float-right" id="reservation" value="{{$date_range ?? ''}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button class="btn btn-outline-success" href="" onclick="previewlist()" type="button">Tampilkan</button>
                                <button id="form-submit" class="btn btn-primary" href="" onclick="cetak(0)" type="submit">Cetak Sebagian</button>
                                <button id="form-submit" class="btn btn-primary" href="" onclick="cetak(1)" type="submit">Cetak Semua</button>
                                <button class="btn btn-default float-right" href="" onclick="refreshForm()" role="button">Batal</button>
                                <!-- <button id="form-batal" class="btn btn-default float-right">Batal</button> -->
                            </div>
                        <!-- </form> -->
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
                    <!-- <div class="card-header">
                        <h3 class="card-title">Daftar Feedback</h3>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table  id="table-list" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Provinsi</th>
                                    <th>Perusahaan</th>
                                    <th>Tanggal Daftar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $i = 5 * $page - 5;
                                ?>
                                @if(isset($registers))
                                @foreach ($registers as $register)
                                <?php
                                    $created_at = date_create($register['created_at']);
                                ?>
                                <tr id="row_{{ $register['id'] }}" onclick="preview({{ json_encode($register) }})">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $register['user_name'] }}</td>
                                    <td>{{ $register['province_name'] }}</td>
                                    <td>{{ $register['comp_name'] ?? "-" }}</td>
                                    <td data-sort='{{date_format($created_at, "Ymd")}}'>{{ date_format($created_at, "d/M/Y") }}</td>
                                    <td onclick="event.cancelBubble=true; return false;">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" onclick="preview({{ json_encode($register) }})" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Preview"><i class=" fas fa-eye"></i></button>
                                            <!-- <button type="button" onclick="edit({{ json_encode($register) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class=" fas fa-edit"></i></button> -->
                                            {{--
                                            <?php if ($register['is_sent'] == null || $register['is_sent'] == 0) {
                                            ?>
                                                <button type="button" onclick="send({{ json_encode($register) }})" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="resend"><i class="fas fa-paper-plane"></i></button>
                                            <?php }else{ ?>
                                                <button type="button" class="btn disabled btn-secondary" data-toggle="tooltip" data-placement="top" title="resend"><i class="fas fa-paper-plane"></i></button>
                                            <?php } ?>
                                        --}}
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
                            <!-- User Information -->
                            <div id="preview_user_information" class="container">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Informasi User:</label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Nama</label>
                                    <input id="preview-user_name" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Jenis Kelamin</label>
                                    <input id="preview-user_gender" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">No Identitas</label>
                                    <input id="preview-user_identity" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">No Hp</label>
                                    <input id="preview-user_phone_number" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Email</label>
                                    <input id="preview-email" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Tanggal Input</label>
                                    <input id="preview-created_at" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Provinsi</label>
                                    <input id="preview-province_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Kota</label>
                                    <input id="preview-city_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Kabupaten</label>
                                    <input id="preview-distric_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Kecamatan</label>
                                    <input id="preview-subdistric_name" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Alamat</label>
                                    <textarea id="preview-user_address" class="form-control col-sm-9" name="" id="" cols="30" rows="10" readonly></textarea>
                                    <!-- <input id="preview-content" class="form-control col-sm-9" type="text" readonly value=""> -->
                                </div>
                            </div>
                            <!-- /User Information -->

                            <!-- Company Information -->
                            <div id="preview_comp_information" class="container">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Informasi Perusahaan:</label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Nama Perusahaan</label>
                                    <input id="preview-comp_name" class="form-control col-sm-9" type="text" readonly>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">No Telepon</label>
                                    <input id="preview-comp_phone" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Email</label>
                                    <input id="preview-comp_email" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Catatan/notes</label>
                                    <input id="preview-comp_notes" class="form-control col-sm-9" type="text" readonly value="">
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="">Alamat Perusahaan</label>
                                    <textarea id="preview-comp_address" class="form-control col-sm-9" name="" id="" cols="30" rows="10" readonly></textarea>
                                    <!-- <input id="preview-content" class="form-control col-sm-9" type="text" readonly value=""> -->
                                </div>
                            </div>
                            <!-- /Company Information -->
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
            window.location = "{{url('cms/pendaftaran')}}";
        }

        var _URL = window.URL || window.webkitURL;

        //Preview/Tampilkan
        function previewlist() {
            let range = document.getElementById("reservation").value;
            window.location = "{{url('cms/pendaftaran')}}?range="+range.toString();
        }

        function isalll() {
            var x = document.getElementById("isall").value;
            if (x === "1") {
                document.getElementById("form-submit").disabled = false;
            } else {
                document.getElementById("form-submit").disabled = true;
            }
            return false;
        }

        //Eksport/cetak
        function cetak(isall) {
            // var x = document.getElementById("isall").value;
            if (isall == 1) {
                Swal.fire({
                    // title: 'Konfirmasi',
                    text: "Cetak semua data pendaftaran?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons : 'true'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            xhrFields: {
                                responseType: 'blob',
                            },
                            url: "{{url('/')}}/export_excel",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                document.getElementById("loading-form").style.visibility = "visible";
                            },
                            success: function(result, status, xhr) {
                                document.getElementById("loading-form").style.visibility = "hidden";

                                var disposition = xhr.getResponseHeader('content-disposition');
                                var matches = /"([^"]*)"/.exec(disposition);
                                var filename = (matches != null && matches[1] ? matches[1] : 'Registers all.xlsx');

                                // The actual download
                                var blob = new Blob([result], {
                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = filename;

                                document.body.appendChild(link);

                                link.click();
                                document.body.removeChild(link);
                            },

                            error: function(response) {
                                console.log(response);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                });
                            },
                        });
                    }
                })

            } else {


                let range = document.getElementById("reservation").value;
                var form = new FormData();
                form.append('range', range);
                var lines = 'Cetak data pendaftaran tanggal<br>' + range +"?";
                Swal.fire({
                    // title: 'Konfirmasi',
                    html: lines,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons : 'true',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            xhrFields: {
                                responseType: 'blob',
                            },
                            url: "{{url('/')}}/export_excel",
                            type: "POST",
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                document.getElementById("loading-form").style.visibility = "visible";
                            },
                            success: function(result, status, xhr) {
                                document.getElementById("loading-form").style.visibility = "hidden";

                                var disposition = xhr.getResponseHeader('content-disposition');
                                var matches = /"([^"]*)"/.exec(disposition);
                                var filename = (matches != null && matches[1] ? matches[1] : 'Registers '+range.replace("/", "_")+'.xlsx');

                                // The actual download
                                var blob = new Blob([result], {
                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = filename;

                                document.body.appendChild(link);

                                link.click();
                                document.body.removeChild(link);
                            },

                            error: function(response) {
                                console.log(response);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan coba lagi'
                                });
                            },
                        });
                    }
                })
            }

            

            return false;
        }
        // Preview
        function preview(detail) {
            //User
            document.getElementById("preview-user_name").value = detail.user_name;
            document.getElementById("preview-user_gender").value = detail.user_gender;
            document.getElementById("preview-user_identity").value = detail.user_identity;
            document.getElementById("preview-email").value = detail.user_email;
            document.getElementById("preview-user_phone_number").value = detail.user_phone_number;
            var date = new Date(detail.created_at);
            document.getElementById("preview-created_at").value =
                ("0" + date.getUTCDate()).slice(-2) + "/" +
                ("0" + (date.getUTCMonth() + 1)).slice(-2) + "/" +
                date.getUTCFullYear();
            document.getElementById("preview-province_name").value = detail.province_name;
            document.getElementById("preview-city_name").value = detail.cities_name;
            document.getElementById("preview-distric_name").value = detail.districts_name;
            document.getElementById("preview-subdistric_name").value = detail.sub_districts_name;
            document.getElementById("preview-user_address").innerHTML = detail.user_address;


            if (detail.comp_name != null) {
                document.getElementById("preview_comp_information").style.display="block";
                //Company
                document.getElementById("preview-comp_name").value = detail.comp_name;
                document.getElementById("preview-comp_phone").value = detail.comp_phone;
                document.getElementById("preview-comp_email").value = detail.comp_email;
                document.getElementById("preview-comp_notes").value = detail.notes;
                document.getElementById("preview-comp_address").innerHTML = detail.comp_address;
            } else {
                document.getElementById("preview_comp_information").style.display="none";
            }

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
