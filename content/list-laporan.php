<?php
require_once '../config/connection.php';
require_once '../config/functions.php';
$func = new Functions();

require_once '../classes/DB.php';
require_once '../classes/Laporan.php';

$laporan = new Laporan();
$data = $_POST['data'];
$laporan = $laporan->getLaporan($data);
?>

<?php if (count($laporan) > 0) : ?>
    <?php $no = 1; ?>
    <?php foreach ($laporan as $data) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $data['no_transaksi'] ?></td>
            <td><?= ucwords($data['nama_pelanggan']) ?></td>
            <td><?= ucwords($data['alamat']) ?></td>
            <td><?= $data['no_hp'] ?></td>
            <td><?= ucwords($data['nama_jasa']) ?></td>
            <td><?= $func->currency($data['harga_satuan']) ?></td>
            <td><?= $data['jumlah'] ?></td>
            <td><?= $func->currency($data['harga_satuan'] * $data['jumlah']) ?></td>
            <td><?= $func->dateIndonesia($data['tgl_trans']) ?></td>
            <td><?= $func->dateIndonesia($data['tgl_selesai']) ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>