<?php
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Transaksi.php';

$transaksi = new Transaksi();

$trans = $transaksi->getTransaksiByNo($_POST['notrans']);
?>

<?php foreach ($trans as $tr) : ?>
    <tr>
        <th><a href="javascript:;" class="text-danger" onclick="removeJasaTrans('<?= $tr['detail_id'] ?>')"><i class="bx bx-trash"></i></a></th>
        <td><?= $tr['nama_jasa'] ?></td>
        <td align="center"><?= $func->currency($tr['harga_satuan']) ?></td>
        <td align="center"><?= $tr['jumlah'] ?></td>
        <td align="center" colspan="2"><?= $func->currency($tr['total']) ?></td>
    </tr>
<?php endforeach; ?>