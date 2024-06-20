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