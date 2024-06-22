<?php
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Riwayat.php';

$riwayat = new Riwayat();
$data = $_POST['data'];
$riwayat = $riwayat->getRiwayat($data);
$no = 1;
?>

<?php foreach ($riwayat as $riw) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $riw['no_transaksi'] ?></td>
        <td><?= $func->dateIndonesia($riw['tgl_trans']) ?></td>
        <td><?= ucwords($riw['nama_pemilik']) ?></td>
        <td align="center"><?= $riw['jumlah_jasa'] ?></td>
        <td><?= $func->currency($riw['total']) ?></td>
        <td>
            <?php if (is_null($riw['status_transaksi'])) : ?>
                <span class="badge bg-secondary">Pending</span>
            <?php elseif ($riw['status_transaksi'] == 1) : ?>
                <span class="badge bg-primary">Proses</span>
            <?php elseif ($riw['status_transaksi'] == 2) : ?>
                <span class="badge bg-success">Selesai</span>
            <?php endif; ?>
        </td>
        <td>
            <a href="javascript:;" onclick="detailTrans('<?= $riw['no_transaksi'] ?>')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail Transaksi"><i class="bx bx-show-alt fs-4"></i></a>
        </td>
    </tr>
<?php endforeach; ?>
<script>
    function detailTrans(no_transaksi) {
        $.ajax({
            url: 'content/modal-detail-transaksi.php',
            type: 'POST',
            data: {
                no_transaksi: no_transaksi,
                action: 'detail_transaksi'
            },
            success: function(response) {
                $('#my-modal-centered').html(response);
                $('#my-modal-centered').modal('show');
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
            }
        })
    }
</script>