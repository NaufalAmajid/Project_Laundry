<?php
$process = $trans->getTransaksiByStatus($_SESSION['the_id'], '= 1');
$no = 1;
?>
<div class="card-header py-3">
    <h6 class="mb-0">Daftar Transaksi Process</h6>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="table-responsive">
                <table class="table align-middle" id="table-transaksi-process">
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
                        <?php foreach ($process as $proc) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $proc['no_transaksi'] ?></td>
                                <td><?= ucwords($proc['nama_pelanggan']) ?></td>
                                <td><?= $proc['alamat'] ?></td>
                                <td><?= $func->dateIndonesia($proc['tgl_trans']) ?></td>
                                <td align="center"><?= $proc['total_jasa'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary" onclick="detailTrans('<?= $proc['no_transaksi'] ?>', '<?= $proc['pelanggan_id'] ?>')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lanjutkan Transaksi"><i class="bx bx-undo fs-4"></i></button>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeNoTrans('<?= $proc['no_transaksi'] ?>')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Transaksi"><i class="bx bx-x fs-4"></i></button>
                                        <button type="button" class="btn btn-outline-success" onclick="doneTrans('<?= $proc['no_transaksi'] ?>')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Transaksi Selesai"><i class="bx bx-check-circle fs-4"></i></button>
                                    </div>
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
        $('#table-transaksi-process').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            }).buttons().container()
            .appendTo('#table-transaksi-process_wrapper .col-md-6:eq(0)');
    })

    function detailTrans(no_transaksi, pelanggan_id) {
        localStorage.setItem('pelanggan_id', pelanggan_id);
        window.location.href = `?page=transaksi&action=baru&notrans=${no_transaksi}`;
    }

    function removeNoTrans(no_transaksi) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "No Transaksi yang akan diHapus, tidak dapat dikembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'classes/Transaksi.php',
                    data: {
                        action: 'remove_no_transaksi',
                        no_transaksi: no_transaksi
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        Lobibox.notify(`${res.status}`, {
                            pauseDelayOnHover: true,
                            size: "mini",
                            rounded: true,
                            delayIndicator: false,
                            delay: 2500,
                            icon: `${res.icon}`,
                            continueDelayOnInactiveTab: false,
                            sound: false,
                            position: "center top",
                            msg: `${res.message}`
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2500);
                    }
                })
            }
        });
    }

    function doneTrans(no_transaksi) {
        Swal.fire({
            title: "Perhatian!",
            text: "Transaksi yang sudah selesai tidak dapat diubah lagi, karena akan masuk ke laporan dan sebagai riwayat. Apakah anda yakin ingin menyelesaikan transaksi ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'classes/Transaksi.php',
                    data: {
                        action: 'done_no_transaksi',
                        no_transaksi: no_transaksi
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        Lobibox.notify(`${res.status}`, {
                            pauseDelayOnHover: true,
                            size: "mini",
                            rounded: true,
                            delayIndicator: false,
                            delay: 2500,
                            icon: `${res.icon}`,
                            continueDelayOnInactiveTab: false,
                            sound: false,
                            position: "center top",
                            msg: `${res.message}`
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2500);
                    }
                })
            }
        });
    }
</script>