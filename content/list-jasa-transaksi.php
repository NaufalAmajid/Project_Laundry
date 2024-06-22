<?php
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Transaksi.php';

$transaksi = new Transaksi();

$trans = $transaksi->getTransaksiByNo($_POST['notrans']);
$totalAll = 0;
?>

<?php foreach ($trans as $tr) : ?>
    <tr>
        <th><a href="javascript:;" class="text-danger" onclick="removeJasaTrans('<?= $tr['detail_id'] ?>')"><i class="bx bx-trash"></i></a></th>
        <td><?= $tr['nama_jasa'] ?></td>
        <td align="center"><?= $func->currency($tr['harga_satuan']) ?></td>
        <td align="center"><?= $tr['jumlah'] ?> <?= $tr['satuan'] ?></td>
        <td align="center" colspan="2"><?= $func->currency($tr['total']) ?></td>
    </tr>
    <?php $totalAll += $tr['total']; ?>
<?php endforeach; ?>
<tr>
    <td colspan="5">
        <hr>
    </td>
</tr>
<tr>
    <td align="end" colspan="4" class="fs-5">Total</td>
    <td align="center" class="fs-5" colspan="2" id="totalAll"><?= $func->currency($totalAll) ?></td>
</tr>
<script>
    function removeJasaTrans(detail_id) {
        $.ajax({
            url: '../admin/classes/Transaksi.php',
            type: 'POST',
            data: {
                action: 'remove_jasa_trans',
                detail_id: detail_id,
            },
            success: function(response) {
                let result = JSON.parse(response);
                Lobibox.notify(`${result.status}`, {
                    pauseDelayOnHover: true,
                    size: "mini",
                    rounded: true,
                    delayIndicator: false,
                    delay: 2000,
                    icon: `bx bx-${result.icon}`,
                    continueDelayOnInactiveTab: false,
                    sound: false,
                    position: "top right",
                    msg: result.message,
                });
                listJasaTransaksi();
            }
        })
    }
</script>