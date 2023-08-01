<?= $this->extend('layouts/app'); ?>

<?= $this->section('css'); ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content-header') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= route_to('App\Controllers\Backend\ManageUrlController::index') ?>">dashboard</a></li>
                    <li class="breadcrumb-item active">report</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-5 mt-2 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Start Date</span>
                            </div>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-2 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">End Date</span>
                            </div>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>
                    <div class="col-lg-2 mt-2 mb-2">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-block" id="btn-search" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <!-- BAR CHART -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title click-title">Click Current year</h3>

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
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-4">
        <!-- PIE CHART -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Platform</h3>

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
                <canvas id="platformChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-4">
    <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Browser</h3>

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
                <canvas id="browserChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-4">
    <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Device</h3>

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
                <canvas id="deviceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2">Loading...</div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    $(function() {
        var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var clickChart;
        var platformChart;
        var deviceChart;
        var browserChart;

        $.ajax({
            type: "POST",
            url: "<?= route_to('App\Controllers\Backend\ManageUrlController::getReportByCurrentYear') ?>",
            data: {
                code: '<?= $url['code'] ?>'
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                var currentMonth = []
                var currentData = []
                var labelPlatform = []
                var labelBrowser = []
                var labelDevice = []
                var deviceData = []
                var platformData = []
                var browserData = []

                $.each(response.data.months, function(index, value) {
                    currentMonth.push(month[index]);
                    currentData.push(parseInt(value.clicks));
                });

                $.each(response.data.urlclicks, function(index, value) {

                    if (index == 'platform') {
                        $.each(value, function(k, v) {
                            labelPlatform.push(v.platform);
                            platformData.push(v.count_platform);
                        });
                    } else if (index == 'browser') {
                        $.each(value, function(k, v) {
                            labelBrowser.push(v.browser);
                            browserData.push(v.count_browser);
                        });
                    } else if (index == 'device') {
                        $.each(value, function(k, v) {
                            labelDevice.push(v.device);
                            deviceData.push(v.count_device);
                        });
                    }
                });

                var areaChartData = {
                    labels: currentMonth,
                    datasets: [{
                        label: 'Clicks',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: currentData
                    }, ]
                }

                var platform = {
                    labels: labelPlatform,
                    datasets: [{
                        data: platformData,
                        backgroundColor: generateColorArray(platformData.length),
                    }]
                }

                var device = {
                    labels: labelDevice,
                    datasets: [{
                        data: deviceData,
                        backgroundColor: generateColorArray(deviceData.length),
                    }]
                }

                var browser = {
                    labels: labelBrowser,
                    datasets: [{
                        data: browserData,
                        backgroundColor: generateColorArray(browserData.length),
                    }]
                }

                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                barChartData.datasets[0] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

              clickChart =  new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })

                 //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var platformChartCanvas = $('#platformChart').get(0).getContext('2d')
        var pieData = platform;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        platformChart = new Chart(platformChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var deviceChartCanvas = $('#deviceChart').get(0).getContext('2d')
        var pieData = device;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
         deviceChart =  new Chart(deviceChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var browserChartCanvas = $('#browserChart').get(0).getContext('2d')
            var pieData = browser;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
           browserChart = new Chart(browserChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            $('.overlay').fadeOut();
        }
        });

        $('#btn-search').click(function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            if (startDate == '' || endDate == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select start date and end date',
                })
            } else {
                $('.overlay').fadeIn();
                $.ajax({
                    type: "POST",
                    url: "<?= route_to('App\Controllers\Backend\ManageUrlController::getReportByDateRange') ?>",
                    data: {
                        code: '<?= $url['code'] ?>',
                        startDate: startDate,
                        endDate: endDate
                    },
                    dataType: "json",
                    success: function(response) {
                     console.log(response);
                var currentMonth = []
                var currentData = []
                var labelPlatform = []
                var labelBrowser = []
                var labelDevice = []
                var deviceData = []
                var platformData = []
                var browserData = []

                $.each(response.data.months, function(index, value) {
                    currentMonth.push(month[index]);
                    currentData.push(parseInt(value.clicks));
                });

                $.each(response.data.urlclicks, function(index, value) {

                    if (index == 'platform') {
                        $.each(value, function(k, v) {
                            labelPlatform.push(v.platform);
                            platformData.push(v.count_platform);
                        });
                    } else if (index == 'browser') {
                        $.each(value, function(k, v) {
                            labelBrowser.push(v.browser);
                            browserData.push(v.count_browser);
                        });
                    } else if (index == 'device') {
                        $.each(value, function(k, v) {
                            labelDevice.push(v.device);
                            deviceData.push(v.count_device);
                        });
                    }
                });

                

                //-------------
                //- BAR CHART -
                //-------------
                clickChart.data.labels = currentMonth;
                clickChart.data.datasets[0].data = currentData;
                clickChart.update();

                 //-------------

                platformChart.data.labels = labelPlatform;
                platformChart.data.datasets[0].data = platformData;
                platformChart.update();

                deviceChart.data.labels = labelDevice;
                deviceChart.data.datasets[0].data = deviceData;
                deviceChart.update();

                browserChart.data.labels = labelBrowser;
                browserChart.data.datasets[0].data = browserData;
                browserChart.update();

            $('.click-title').text('Click from ' + startDate + ' to ' + endDate);
            $('.overlay').fadeOut();
                    }
                });
            }
        });

        function generateColorArray(length) {
            var colorArray = [];
            var hueStep = 360 / length;

            for (var i = 0; i < length; i++) {
                var hue = i * hueStep;
                var color = 'hsl(' + hue + ', 70%, 50%)';
                colorArray.push(color);
            }

            return colorArray;
        }
    })
</script>
<?= $this->endSection(); ?>