<?php
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Transaksi.php';
$transaksi = new Transaksi();
$transaksi = $transaksi->getTransaksiByNo($_POST['no_transaksi']);
?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Transaksi</h5>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Jasa</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $trans) : ?>
                            <tr>
                                <td><?= ucwords($trans['nama_jasa']) ?></td>
                                <td><?= $trans['jumlah'] ?></td>
                                <td><?= $func->currency($trans['harga_satuan']) ?></td>
                                <td><?= $func->currency($trans['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>