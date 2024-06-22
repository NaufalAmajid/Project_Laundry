<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Laporan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="?mydashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>">Laporan</a></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<?php
require_once 'classes/Laporan.php';

$laporan = new Laporan();
?>
<div class="row">
    <div class="col-12 col-lg-9 d-flex">
        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="table-history-trans">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Jasa</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Tanggal Transaksi</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody id="list-laporan">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 d-flex">
        <div class="card w-100">
            <div class="card-header py-3">
                <h5 class="mb-0">Filter by</h5>
            </div>
            <div class="card-body">
                <form class="row g-3" id="form-search-history">
                    <div class="col-12">
                        <label class="form-label">No Transaksi</label>
                        <input type="text" class="form-control" name="no_transaksi">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Jasa</label>
                        <select class="form-select" name="nama_jasa">
                            <option value="">Semua Jasa</option>
                            <?php foreach ($laporan->getJasaByHistory() as $pelanggan) : ?>
                                <option value="<?= $pelanggan['nama_jasa'] ?>"><?= ucwords($pelanggan['nama_jasa']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Pelanggan</label>
                        <select class="form-select" name="nama_pelanggan">
                            <option value="">Semua Pelanggan</option>
                            <?php foreach ($laporan->getPelangganByHistory() as $pelanggan) : ?>
                                <option value="<?= $pelanggan['nama_pelanggan'] ?>"><?= ucwords($pelanggan['nama_pelanggan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Range Tanggal</label>
                        <input type="date" class="form-control" name="first_date" value="<?= date('Y-m-01') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Sampai</label>
                        <input type="date" class="form-control" name="second_date" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary" id="btn-search-history" type="button" onclick="searchLaporan()">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        searchLaporan();
    })

    function searchLaporan() {
        $('#table-history-trans').DataTable().destroy();
        let data = $('#form-search-history').serializeArray();
        let send = {};
        data.forEach((item) => {
            send[item.name] = item.value;
        });
        $.ajax({
            url: 'content/list-laporan.php',
            type: 'POST',
            data: {
                action: 'getLaporan',
                data: send
            },
            success: function(response) {
                $('#list-laporan').html(response);
                $('#table-history-trans').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        info: false
                    }).buttons().container()
                    .appendTo('#table-history-trans_wrapper .col-md-6:eq(0)');
                // console.log(response);
            }
        })
    }
</script>