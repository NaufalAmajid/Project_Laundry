<?php

class Transaksi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getTransaksiByNo($notrans)
    {
        $query = "select
                        dt.id as detail_id,
                        trans.no_transaksi,
                        depel.nama_pelanggan,
                        dj.nama_jasa,
                        dt.jumlah,
                        dj.harga_satuan,
                        (dj.harga_satuan * dt.jumlah) as total
                    from
                        transaksi trans
                    inner join detail_transaksi dt on
                        trans.no_transaksi = dt.no_transaksi
                    inner join detail_pelanggan depel on
                        trans.pelanggan_id = depel.pelanggan_id
                    inner join daftar_jasa dj on
                        dt.jasa_id = dj.jasa_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function checkNoTransaksi($no_transaksi)
    {
        $query = "SELECT * FROM transaksi WHERE no_transaksi = :no_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':no_transaksi', $no_transaksi);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addNoTransaksi($data)
    {
        $db = DB::getInstance();
        $res = $db->add('transaksi', $data);
        $id = $this->conn->lastInsertId();
        return $id;
    }

    public function addTransaksi($data)
    {
        $db = DB::getInstance();
        $res = $db->add('detail_transaksi', $data);
        $id = $this->conn->lastInsertId();
        return $id;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $transaksi = new Transaksi();
    if ($_POST['action'] == 'add_transaksi') {

        $checkNoTransaksi = $transaksi->checkNoTransaksi($_POST['notrans']);
        if (!$checkNoTransaksi) {
            $dataNoTransaksi = [
                'no_transaksi' => $_POST['notrans'],
                'pelanggan_id' => $_POST['pelanggan_id'],
                'pemilik_id' => $_POST['pemilik_id'],
            ];
            $addNoTransaksi = $transaksi->addNoTransaksi($dataNoTransaksi);
        }

        $dataTransaksi = [
            'no_transaksi' => $_POST['notrans'],
            'jasa_id' => $_POST['jasa_id'],
            'jumlah' => $_POST['quantity'],
        ];
        $addTransaksi = $transaksi->addTransaksi($dataTransaksi);

        if ($addTransaksi) {
            $response = [
                'status' => 'success',
                'message' => 'Transaksi berhasil ditambahkan',
                'id' => $addTransaksi,
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Transaksi gagal ditambahkan',
                'icon' => 'bx bx-error-circle',
            ];
        }

        echo json_encode($response);
    }
}
