<!DOCTYPE html>
<html>

<head>
    <!-- Head -->
    @include('cms-omi.template.head')
    <!-- /Head -->

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
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/cms')}}">Home</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        @if ($_SESSION["roles"] == 1)
                        <div class="col-md-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>User</h3>

                                    <p>Kelola User</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="{{url('/cms/user')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        @endif

                        <!-- ./col -->
                        <div class="col-md-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>Banner</h3>

                                    <p>Kelola Banner</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <a href="{{url('/cms/banner')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-md-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Berita</h3>

                                    <p>Kelola Berita</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <a href="{{url('/cms/blog')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-md-4 col-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>Promosi</h3>

                                    <p>Kelola Promosi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <a href="{{url('/cms/promosi')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-md-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Pendaftaran</h3>

                                    <p>Kelola Pendaftaran</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="{{url('/cms/pendaftaran')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-md-4 col-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>Feedback</h3>

                                    <p>Kelola Feedback</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <a href="{{url('/cms/feedback')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- LINE CHART -->
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fa fa-chart-line"></i>
                                        Pengunjung 7 Hari Terakhir
                                    </h3>

                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                        <div class="col-md-6">

                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fa fa-chart-bar"></i>
                                        Total Pengunjung
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="total-visitor">
                                        <h2 id="jumlah-pengunjung"  class="mx-auto"></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="far fa-file-alt"></i>
                                        Halaman Sering Dikunjungi
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body-->
                            </div>

                            <!-- /.card -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- footer -->
        @include('cms-omi.template.footer')
        <!-- /footer -->

    </div>
    <!-- ./wrapper -->

    <!-- FLOT CHARTS -->
    <script src="{{ asset('admin-lte/plugins/flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('admin-lte/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('admin-lte/plugins/flot/plugins/jquery.flot.pie.js') }}"></script>

    <script>
        var public_host = <?php echo json_encode(url('/')); ?>;

        // ---------------------
        // - Totoal Pengunjung -
        // ---------------------
        $.ajax({
        url: public_host+"/cms/totalVisitor",
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            var total = 0;
            response.forEach(visitors => {
            total += visitors['visitors'];
            });
            // console.log(total);
        document.getElementById("jumlah-pengunjung").innerHTML = total + " Pengunjung";
        },
            error: function(response) {
                console.log(response.responseText);
            },
        });

        // -------------
        // - PIE CHART -
        // -------------
        $.ajax({
        url: public_host+"/cms/pageview",
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
        var urls = [ ];
        var views = [ ];
        for (var i = 0; i < response.length; i++) {
            var split = response[i]['url'].split("/");
            var pageUrls = split[split.length - 1];
            if (pageUrls == "") {
                urls.push("Beranda");
            } else {
                urls.push(pageUrls);
            }
            views.push(response[i]['pageViews']);
                if(i===4){
                    break
                }
            // console.log(split);
            }
            console.log(response);
            
            // --- Create Pie Chart ---
            var donutData        = {
                labels: urls,
                datasets: [
                    {
                    data: views,
                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                    }
                ]
            }
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = donutData;
            var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
            });

            // --- End Create Pie Chart ---
            },
            error: function(response) {
                console.log(response.responseText);
            },
        });
        /* END PIE CHART */

        //-------------
        //- LINE CHART -
        //--------------
        $.ajax({
            url: public_host+"/cms/visitor",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var visitor = [ ];
                var label = [ ];
                response.forEach(visitors => {
                    visitor.push(visitors['visitors']);
                    var tgl = new Date(visitors['date']);
                    var curr_date = (tgl.getDate() < 10 ? '0' : '') + tgl.getDate();
                    var curr_month = tgl.getMonth() + 1;
                    var taggal = curr_date + "/" + curr_month
                    label.push(taggal);
                });

                var areaChartData = {
                labels  : label,
                datasets: [{
                    label               : 'Visitor',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : visitor,
                    }]
                }

                var areaChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }],
                    yAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }]
                }
            }

            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
                // console.log(response);
            },
            error: function(response) {
                console.log(response.responseText);
            },
        });
        /* END LINE CHART */
    </script>
</body>

</html>
