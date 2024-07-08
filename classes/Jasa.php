<?php

class Jasa
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addJasa($data)
    {
        $db = DB::getInstance();
        return $db->add('daftar_jasa', $data);
    }

    public function editJasa($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('daftar_jasa', $data, $where);
    }

    public function getAllJasaTrans()
    {
        $query = "SELECT * FROM daftar_jasa WHERE is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getAllJasa()
    {
        $query = "SELECT
                    dj.jasa_id,
                    dj.nama_jasa,
                    dj.harga_satuan,
                    dj.is_active,
                    dj.satuan,
                    COUNT(CASE WHEN dt.status_transaksi IS NULL THEN dt.id END) AS jumlah_orderan_pending,
                    COUNT(CASE WHEN dt.status_transaksi = 1 THEN dt.id END) AS jumlah_orderan_proses,
                    COUNT(CASE WHEN dt.status_transaksi = 2 THEN dt.id END) AS jumlah_orderan_selesai
                FROM
                    daftar_jasa dj
                LEFT JOIN detail_transaksi dt ON
                    dj.jasa_id = dt.jasa_id
                GROUP BY
                    dj.jasa_id,
                    dj.nama_jasa,
                    dj.harga_satuan,
                    dj.satuan,
                    dj.is_active";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getJasaById($id)
    {
        $query = "SELECT * FROM daftar_jasa WHERE jasa_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $jasa = new Jasa();

    if ($_POST['action'] == 'add_jasa') {
        $data = [
            'nama_jasa' => $_POST['nama_jasa'],
            'satuan' => $_POST['satuan'],
            'harga_satuan' => $_POST['harga_satuan'],
        ];

        $add = $jasa->addJasa($data);
        if ($add) {
            echo json_encode(['status' => 'success', 'msg' => 'Jasa berhasil ditambahkan', 'icon' => 'check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Jasa gagal ditambahkan', 'icon' => 'error']);
        }
    }

    if ($_POST['action'] == 'get_jasa_by_id') {
        $data = $jasa->getJasaById($_POST['jasa_id']);
        echo json_encode($data);
    }

    if ($_POST['action'] == 'update_jasa') {
        $data = [
            'nama_jasa' => $_POST['nama_jasa'],
            'satuan' => $_POST['satuan'],
            'harga_satuan' => $_POST['harga_satuan'],
        ];

        $where = ['jasa_id' => $_POST['jasa_id']];
        $update = $jasa->editJasa($data, $where);
        if ($update > 0) {
            echo json_encode(['status' => 'success', 'msg' => 'Jasa berhasil diupdate', 'icon' => 'check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Jasa gagal diupdate', 'icon' => 'error']);
        }
    }

    if ($_POST['action'] == 'delete_jasa') {
        $data = [
            'is_active' => $_POST['is_active'],
        ];
        $where = ['jasa_id' => $_POST['jasa_id']];
        $update = $jasa->editJasa($data, $where);
        if ($update > 0) {
            if ($_POST['is_active'] == 0) {
                echo json_encode(['status' => 'info', 'msg' => 'Jasa berhasil dinonaktifkan', 'icon' => 'info-circle']);
            } else {
                echo json_encode(['status' => 'success', 'msg' => 'Jasa berhasil diaktifkan', 'icon' => 'check-circle']);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Jasa gagal dihapus', 'icon' => 'error']);
        }
    }
}
