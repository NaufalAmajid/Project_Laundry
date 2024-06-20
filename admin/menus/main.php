<?php
require_once 'classes/Dashboard.php';

$dashboard = new Dashboard();
?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
    <?php $byStatus = $dashboard->getDetailOrderByStatus(); ?>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-orange border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Total Order</p>
                        <h4 class="mb-0 text-orange"><?= $byStatus['total_order'] ?></h4>
                    </div>
                    <div class="ms-auto widget-icon bg-orange text-white">
                        <i class="bx bx-cart-alt fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-secondary border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Laundry Pending</p>
                        <h4 class="mb-0 text-secondary"><?= $byStatus['order_pending'] ?></h4>
                    </div>
                    <div class="ms-auto widget-icon bg-secondary text-white">
                        <i class="bx bx-loader-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-success border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Laundry Proses</p>
                        <h4 class="mb-0 text-success"><?= $byStatus['order_proses'] ?></h4>
                    </div>
                    <div class="ms-auto widget-icon bg-success text-white">
                        <i class="bx bx-timer fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-danger border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Laundry Selesai</p>
                        <h4 class="mb-0 text-danger"><?= $byStatus['order_selesai'] ?></h4>
                    </div>
                    <div class="ms-auto widget-icon bg-danger text-white">
                        <i class="bx bx-task fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h6 class="mb-0 text-uppercase">Data</h6>
<hr>
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-6 row-cols-xxl-6">
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
                    <i class="lni lni-users fs-4"></i>
                </div>
                <h3>25</h3>
                <p class="mb-0">Pelanggan</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-danger text-danger">
                    <i class="bx bx-user-circle fs-4"></i>
                </div>
                <h3>35</h3>
                <p class="mb-0">Pemilik</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                    <i class="lni lni-layers fs-4"></i>
                </div>
                <h3>16</h3>
                <p class="mb-0">Jasa</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-info text-info">
                    <i class="lni lni-cart-full fs-4"></i>
                </div>
                <h3>18</h3>
                <p class="mb-0">Order Hari Ini</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-purple text-purple">
                    <i class="lni lni-cart fs-4"></i>
                </div>
                <h3>22</h3>
                <p class="mb-0">Order Minggu Ini</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-orange text-orange">
                    <i class="bx bx-cart-alt fs-4"></i>
                </div>
                <h3>45</h3>
                <p class="mb-0">Order Bulan Ini</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0">Pendapatan</h6>
                    <div class="fs-5 ms-auto dropdown">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div id="chart5"></div>
            </div>
        </div>
    </div>
</div>
<script src="assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<script>
    $(function() {
        var options = {
            series: [{
                name: "Pendapatan",
                data: [240, 460, 171, 657, 160, 471, 340, 230, 458, 98, 105, 1000]
            }],
            chart: {
                type: "area",
                // width: 130,
                stacked: true,
                height: 280,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: .12,
                    color: "#3461ff"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#3461ff"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "25%",
                    //endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: [2.5],
                //colors: ["#3461ff"],
                curve: "smooth"
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#3361ff'],
                    inverseColors: false,
                    opacityFrom: 0.7,
                    opacityTo: 0.1,
                    // stops: [0, 100]
                }
            },
            colors: ["#3361ff"],
            xaxis: {
                categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            },
            grid: {
                show: true,
                borderColor: 'rgba(66, 59, 116, 0.15)',
            },
            responsive: [{
                breakpoint: 1000,
                options: {
                    chart: {
                        type: "area",
                        // width: 130,
                        stacked: true,
                    }
                }
            }],
            legend: {
                show: false
            },
            tooltip: {
                theme: "dark",
                y: {
                    formatter: function(val) {
                        return "Rp " + val + "K"
                    },
                },

            }
        };

        var chart = new ApexCharts(document.querySelector("#chart5"), options);
        chart.render();
    })
</script>