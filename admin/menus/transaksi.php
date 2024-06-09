<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Transaksi</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <?php if (isset($_GET['action'])) : ?>
                    <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>">Transaksi <?= ucwords($_GET['action']) ?></a></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-primary" onclick="actionTrans('baru')">Buat Transaksi</button>
            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                <a class="dropdown-item" href="javascript:;" onclick="actionTrans('pending')">Pending</a>
                <a class="dropdown-item" href="javascript:;" onclick="actionTrans('proses')">Proses</a>
                <a class="dropdown-item" href="javascript:;" onclick="actionTrans('selesai')">Selesai</a>
            </div>
        </div>
    </div>
</div>
<!--end breadcrumb-->
<?php
require_once 'classes/Transaksi.php';
$trans = new Transaksi();
?>
<div class="card">
    <div class="card-header py-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-4 col-md-6 me-auto">
                <h5 class="mb-1"><?= $func->dateIndonesia(date('Y-m-d')) . ' ' . date('H:i') ?></h5>
                <p class="mb-0">No Transaksi : <?= isset($_GET['notrans']) ? $_GET['notrans'] : '-' ?></p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col">
                        <div class="card border shadow-none radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg-light-success border-0">
                                        <i class="bx bx-user-pin fs-3 text-success"></i>
                                    </div>
                                    <div class="info">
                                        <h6 class="mb-2">Kasir</h6>
                                        <p class="mb-1"><strong>Username</strong> : <?= ucwords($_SESSION['username']) ?></p>
                                        <p class="mb-1"><strong>Nama</strong> : <?= ucwords($_SESSION['nama']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card border shadow-none radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="info">
                                        <h6 class="mb-2">Pelanggan <span><a href="javascript:;" onclick="modalAddPelanggan()" class="text-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Buat Pelanggan Baru" aria-label="pelanggan_baru"><i class="bx bx-error-alt fs-5"></i></a></span></h6>
                                        <div class="mb-1">
                                            <select name="pelanggan" id="pelanggan" class="select2 custom-border-bottom form-control" onchange="detailPelanggan()">
                                                <option value="">Pilih Pelanggan</option>
                                                <?php
                                                $pelanggans = $trans->getAllPelanggan();
                                                foreach ($pelanggans as $pelanggan) :
                                                ?>
                                                    <option value="<?= $pelanggan['pelanggan_id'] ?>" data-username="<?= $pelanggan['username'] ?>" data-nama="<?= $pelanggan['nama_pelanggan'] ?>" data-nohp="<?= $pelanggan['no_hp'] ?>" data-alamat="<?= $pelanggan['alamat'] ?>"><?= ucwords($pelanggan['nama_pelanggan']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <p class="mb-1"><strong>Username</strong> : <span id="username-pelanggan"></span></p>
                                        <p class="mb-1"><strong>Nama</strong> : <span id="nama-pelanggan"></span></p>
                                        <p class="mb-1"><strong>No</strong> : <span id="nohp-pelanggan"></span></p>
                                        <p class="mb-1"><strong>Alamat</strong> : <span id="alamat-pelanggan"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="row">
                    <div class="col">
                        <div class="card border shadow-none radius-10">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>Layanan</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah / Berat</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><a href="javascript:;" class="text-danger"><i class="bx bx-trash"></i></a></th>
                                                <td>Laundry Reguler</td>
                                                <td align="center">3.500</td>
                                                <td align="center">2</td>
                                                <td align="center">7.000</td>
                                            </tr>
                                            <tr>
                                                <th><a href="javascript:;" class="text-danger"><i class="bx bx-trash"></i></a></th>
                                                <td>Laundry Reguler</td>
                                                <td align="center">3.500</td>
                                                <td align="center">2</td>
                                                <td align="center">7.000</td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="5">
                                                <hr>
                                            </td>
                                        </tr>
                                        <tfoot>
                                            <tr>
                                                <td align="end" colspan="4" class="fs-5">Total</td>
                                                <td align="center" class="fs-5">14.000</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#pelanggan').select2({
            placeholder: 'Pilih Pelanggan',
        })
    })

    function getFormattedDate() {
        var now = new Date();

        var year = now.getFullYear();
        var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
        var day = now.getDate().toString().padStart(2, '0');
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');

        return year + month + day + hours + minutes + seconds;
    }


    function actionTrans(act) {
        if (act == 'baru') {
            let noTrans = getFormattedDate();
            window.location.href = '?page=transaksi&action=baru&notrans=' + noTrans;
        } else if (act == 'pending') {
            window.location.href = '?page=transaksi&action=pending';
        } else if (act == 'proses') {
            window.location.href = '?page=transaksi&action=proses';
        } else if (act == 'selesai') {
            window.location.href = '?page=transaksi&action=selesai';
        }
    }

    function detailPelanggan() {
        let pelanggan = $('#pelanggan').find(':selected');
        let username = pelanggan.data('username');
        let nama = pelanggan.data('nama');
        let nohp = pelanggan.data('nohp');
        let alamat = pelanggan.data('alamat');

        $('#username-pelanggan').text(username);
        $('#nama-pelanggan').text(nama);
        $('#nohp-pelanggan').text(nohp);
        $('#alamat-pelanggan').text(alamat);
    }

    function modalAddPelanggan() {
        $.ajax({
            url: 'content/modal-add-pelanggan.php',
            success: function(response) {
                $('#my-modal-centered').html(response);
                $('#my-modal-centered').modal('show');
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
            }
        })
    }
</script>