<?php

class Pemilik
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addPemilik($data)
    {
        $db = DB::getInstance();
        $res = $db->add('detail_pemilik', $data);
        return $res;
    }

    public function updatePemilik($table, $data, $where)
    {
        $db = DB::getInstance();
        $res = $db->update($table, $data, $where);
        return $res;
    }

    public function addUser($data)
    {
        $db = DB::getInstance();
        $result = $db->add('user', $data);
        $user_id = $this->conn->lastInsertId();
        return $user_id;
    }

    public function getAllPemilik()
    {
        $query = "SELECT
                        dp.*,
                        usr.*
                    FROM
                        detail_pemilik dp
                    JOIN user usr ON
                        dp.user_id = usr.user_id
                    WHERE
                        usr.is_active = 1 AND usr.role_id = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPemilikById($pemilik_id)
    {
        $query = "SELECT
                        dp.*,
                        usr.*
                    FROM
                        detail_pemilik dp
                    JOIN user usr ON
                        dp.user_id = usr.user_id
                    WHERE
                        dp.pemilik_id = :pemilik_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pemilik_id', $pemilik_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUser($username)
    {
        $query = "SELECT * FROM user WHERE username = :username AND is_active = 1 AND role_id = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTransaksiByPemilikId($pemilik_id)
    {
        $query = "SELECT
                        *
                    FROM
                        detail_transaksi dt
                    JOIN transaksi trans ON
                        dt.no_transaksi = trans.no_transaksi
                    WHERE
                        trans.pemilik_id = :pemilik_id
                        AND (dt.status_transaksi IS NULL
                            OR dt.status_transaksi = 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("pemilik_id", $pemilik_id);
        $stmt->execute();

        $transaksi = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transaksi[] = $row;
        }
        return $transaksi;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $pemilik = new Pemilik();
    if ($_POST['action'] == 'add_pemilik') {
        foreach ($_POST['data'] as $field => $value) {
            $data[$field] = $value;
        }

        $checkUser = $pemilik->checkUser($data['username']);
        if ($checkUser) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh pemilik lain', 'icon' => 'bx bx-error-circle']);
            exit;
        }

        $dataUser = [
            'username' => $data['username'],
            'password' => md5($data['password']),
            'role_id' => 1,
        ];
        $addUser = $pemilik->addUser($dataUser);

        $dataPemilik = [
            'user_id' => $addUser,
            'nama_pemilik' => $data['nama_pemilik'],
        ];
        $addPemilik = $pemilik->addPemilik($dataPemilik);

        if ($addPemilik) {
            echo json_encode(['status' => 'success', 'message' => 'Pemilik berhasil ditambahkan', 'icon' => 'bx bx-check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Pemilik gagal ditambahkan', 'icon' => 'bx bx-error-circle']);
        }
    }

    if ($_POST['action'] == 'edit_pemilik') {

        foreach ($_POST['data'] as $field => $value) {
            $data[$field] = $value;
        }


        $checkUser = $pemilik->checkUser($data['username']);
        if ($checkUser) {
            if (intval($data['user_id']) != $checkUser['user_id']) {
                echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh pemilik lain', 'icon' => 'bx bx-error-circle']);
                exit;
            }
        }

        $dataEditUser = [
            'username' => $data['username'],
        ];
        $updateUser = $pemilik->updatePemilik('user', $dataEditUser, ['user_id' => $data['user_id']]);

        $dataEditPemilik = [
            'nama_pemilik' => $data['nama_pemilik'],
        ];
        $updatePemilik = $pemilik->updatePemilik('detail_pemilik', $dataEditPemilik, ['pemilik_id' => $data['pemilik_id']]);

        if ($updatePemilik || $updateUser) {
            echo json_encode(['status' => 'success', 'message' => 'User dan pemilik berhasil diubah', 'icon' => 'bx bx-check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User dan pemilik gagal diubah', 'icon' => 'bx bx-error-circle']);
        }
    }

    if ($_POST['action'] == 'delete_pemilik') {
        $checkTransaksi = $pemilik->getTransaksiByPemilikId($_POST['pemilik_id']);
        if (count($checkTransaksi) > 0) {
            $transPending = 0;
            $transProcess = 0;
            foreach ($checkTransaksi as $ct) {
                if (is_null($ct['status_transaksi'])) {
                    $transPending++;
                } else {
                    $transProcess++;
                }
            }
            echo json_encode(['status' => 'info', 'message' => "Pemilik tidak bisa dihapus karena masih memiliki transaksi dengan status <br> - Pending: $transPending <br> - Process: $transProcess", 'time' => 5000]);
            exit;
        } else {
            $editUser = $pemilik->updatePemilik('user', ['is_active' => 0], ['user_id' => $_POST['user_id']]);

            if ($editUser) {
                echo json_encode(['status' => 'success', 'message' => 'Pemilik berhasil dihapus', 'time' => 2000]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Pemilik gagal dihapus', 'time' => 2000]);
            }
        }
    }
}
