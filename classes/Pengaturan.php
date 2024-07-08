<?php

class Pengaturan
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getPengaturan()
    {
        $query = "SELECT * FROM pengaturan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePengaturan($data, $where)
    {
        $db = DB::getInstance();
        return $db->update('pengaturan', $data, $where);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $set = new Pengaturan();

    if ($_POST['page'] == 'update-setting') {
        parse_str($_POST['data'], $data);
        $where = ['id' => 1];
        $update = $set->updatePengaturan($data, $where);
        if ($update > 0) {
            echo json_encode(['status' => 'success', 'msg' => 'Pengaturan berhasil diupdate', 'icon' => 'check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Pengaturan gagal diupdate', 'icon' => 'error']);
        }
    }
}
