<?php
sleep(3);
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Transaksi.php';

$transaksi = new Transaksi();
$notrans = parse_str($_POST['data'], $data);
$transaksi = $transaksi->getTransaksiByNo($data['notrans']);
?>

<?php foreach ($transaksi as $trans) : ?>
    <tr>
        <td><?= ucwords($trans['nama_jasa']) ?></td>
        <td><?= $trans['jumlah'] ?></td>
        <td><?= $func->currency($trans['harga_satuan']) ?></td>
        <td><?= $func->currency($trans['total']) ?></td>
        <td>
            <?php if (is_null($trans['status_transaksi'])) : ?>
                <span class="badge bg-secondary">Pending</span>
            <?php elseif ($trans['status_transaksi'] == 1) : ?>
                <span class="badge bg-primary">Proses</span>
            <?php else : ?>
                <span class="badge bg-success">Selesai</span>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>