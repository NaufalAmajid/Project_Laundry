<?php
error_reporting(0);
?>
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
    <?php if ($_GET['action'] == 'baru') : ?>
        <?php require_once 'content/transaksi/baru.php'; ?>
    <?php elseif ($_GET['action'] == 'pending') : ?>
        <?php require_once 'content/transaksi/pending.php'; ?>
    <?php elseif ($_GET['action'] == 'proses') : ?>
        <?php require_once 'content/transaksi/proses.php'; ?>
    <?php elseif ($_GET['action'] == 'selesai') : ?>
        <?php require_once 'content/transaksi/selesai.php'; ?>
    <?php endif; ?>
</div>
<script>
    $(function() {
        $('#pelanggan').select2({
            placeholder: 'Pilih Pelanggan',
        })

        if (window.location.href.indexOf('action') == -1) {
            actionTrans('baru');
        }

        let pelanggan_id = localStorage.getItem('pelanggan_id');
        if (pelanggan_id) {
            $('#pelanggan').val(pelanggan_id).trigger('change');
            detailPelanggan();
        }
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
        localStorage.removeItem('pelanggan_id');
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

        localStorage.setItem('pelanggan_id', $('#pelanggan').val());

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