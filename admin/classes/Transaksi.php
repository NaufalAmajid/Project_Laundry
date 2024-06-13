<?php
date_default_timezone_set('Asia/Jakarta');

class Transaksi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getTransaksiByStatus($pemilik_id, $status = 'IS NULL')
    {
        $query = "SELECT
                    trans.no_transaksi,
                    trans.status_transaksi,
                    trans.pelanggan_id,
                    date_format(trans.created_at, '%Y-%m-%d') AS tgl_trans,
                    depel.nama_pelanggan,
                    depel.alamat,
                    COUNT(dt.id) AS total_jasa 
                FROM
                    transaksi trans
                INNER JOIN detail_pelanggan depel ON
                    trans.pelanggan_id = depel.pelanggan_id
                LEFT JOIN detail_transaksi dt ON
                    trans.no_transaksi = dt.no_transaksi
                WHERE
                    trans.pemilik_id = $pemilik_id
                    AND dt.status_transaksi $status
                GROUP BY 
                    trans.no_transaksi,
                    trans.status_transaksi,
                    depel.nama_pelanggan,
                    depel.alamat";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDescriptionTrans($notrans)
    {
        $query = "SELECT
                    trans.no_transaksi,
                    trans.status_transaksi,
                    date_format(trans.created_at, '%Y-%m-%d') AS tgl_trans,
                    date_format(trans.created_at, '%H:%i') as jam_trans,
                    depem.nama_pemilik,
                    depel.nama_pelanggan,
                    depel.alamat,
                    depel.no_hp 
                FROM
                    transaksi trans
                INNER JOIN detail_pemilik depem ON
                    trans.pemilik_id = depem.pemilik_id
                INNER JOIN detail_pelanggan depel ON
                    trans.pelanggan_id = depel.pelanggan_id
                WHERE
                    trans.no_transaksi = :no_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':no_transaksi', $notrans);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
                        dt.jasa_id = dj.jasa_id
                    where
                        trans.no_transaksi = :no_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':no_transaksi', $notrans);
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

    public function editTransaksi($table, $data, $where)
    {
        $db = DB::getInstance();
        return $db->update($table, $data, $where);
    }

    public function removeTransaksi($table, $where)
    {
        $db = DB::getInstance();
        $res = $db->delete($table, $where);
        return $res;
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
                'created_at' => date('Y-m-d H:i:s')
            ];
            $addNoTransaksi = $transaksi->addNoTransaksi($dataNoTransaksi);
        }

        $dataTransaksi = [
            'no_transaksi' => $_POST['notrans'],
            'jasa_id' => $_POST['jasa_id'],
            'jumlah' => $_POST['quantity'],
            'created_at' => date('Y-m-d H:i:s')
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

    if ($_POST['action'] == 'remove_jasa_trans') {
        $remove = $transaksi->removeTransaksi('detail_transaksi', ['id' => $_POST['detail_id']]);
        if ($remove) {
            echo json_encode(['status' => 'success', 'message' => 'Jasa transaksi berhasil dihapus', 'icon' => 'bx bx-check']);
        } else {
            echo json_encode(['status' => 'error', ' message' => 'Jasa transaksi gagal dihapus', 'icon' => 'bx bx-error-circle']);
        }
    }

    if ($_POST['action'] == 'change_status') {

        $dataEdit = [
            'status_transaksi' => 1
        ];

        $where = [
            'no_transaksi' => $_POST['notrans']
        ];

        $editTrans = $transaksi->editTransaksi('transaksi', $dataEdit, $where);
        $editDetailTrans = $transaksi->editTransaksi('detail_transaksi', $dataEdit, $where);

        if ($editTrans > 0 && $editDetailTrans > 0) {
            $response = [
                'status' => 'success',
                'msg' => 'Status Transaksi Berhasil Diperbaharui.',
                'icon' => 'bx bx-check'
            ];
        } else {
            $response = [
                'status' => 'error',
                'msg' => 'Status Transaksi Gagal Diperbaharui.',
                'icon' => 'bx bx-error-circle'
            ];
        }

        echo json_encode($response);
    }
}
