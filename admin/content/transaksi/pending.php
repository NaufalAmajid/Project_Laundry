<?php
$pendings = $trans->getTransaksiByStatus($_SESSION['the_id']);
$no = 1;
?>
<div class="card-header py-3">
    <h6 class="mb-0">Daftar Transaksi Pending</h6>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="table-responsive">
                <table class="table align-middle" id="table-transaksi-pending">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Jumlah Jasa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendings as $pending) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $pending['no_transaksi'] ?></td>
                                <td><?= ucwords($pending['nama_pelanggan']) ?></td>
                                <td><?= $pending['alamat'] ?></td>
                                <td><?= $func->dateIndonesia($pending['tgl_trans']) ?></td>
                                <td align="center"><?= $pending['total_jasa'] ?></td>
                                <td>
                                    <a href="javascript:;" onclick="detailTrans('<?= $pending['no_transaksi'] ?>', '<?= $pending['pelanggan_id'] ?>')" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lanjutkan Transaksi"><i class="bx bx-undo fs-4"></i></a>
                                    <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Transaksi" onclick="detailTrans('<?= $pending['no_transaksi'] ?>')"><i class="bx bx-x fs-4"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#table-transaksi-pending').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            }).buttons().container()
            .appendTo('#table-transaksi-pending_wrapper .col-md-6:eq(0)');
    })

    function detailTrans(no_transaksi, pelanggan_id) {
        localStorage.setItem('pelanggan_id', pelanggan_id);
        window.location.href = `?page=transaksi&action=baru&notrans=${no_transaksi}`;
    }
</script>