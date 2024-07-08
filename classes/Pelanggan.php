<?php

class Pelanggan
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function addPelanggan($data)
    {
        $db = DB::getInstance();
        $res = $db->add('detail_pelanggan', $data);
        return $res;
    }

    public function addUser($data)
    {
        $db = DB::getInstance();
        $result = $db->add('user', $data);
        $user_id = $this->conn->lastInsertId();
        return $user_id;
    }

    public function updatePelanggan($table, $data, $where)
    {
        $db = DB::getInstance();
        $res = $db->update($table, $data, $where);
        return $res;
    }

    public function deletePelanggan($table, $where)
    {
        $db = DB::getInstance();
        $res = $db->delete($table, $where);
        return $res;
    }

    public function checkUser($username)
    {
        $query = "SELECT * FROM user WHERE username = :username AND is_active = 1 AND role_id = 2";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPelanggan()
    {
        $query = "SELECT
                    usr.username,
                    usr.is_active,
                    dp.*
                FROM
                    detail_pelanggan dp
                LEFT JOIN user usr ON
                    dp.user_id = usr.user_id
                WHERE
                    usr.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $pelanggan = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pelanggan[] = $row;
        }

        return $pelanggan;
    }

    public function getAllPelangganById($pelangganId)
    {
        $query = "SELECT
                    *
                FROM
                    detail_pelanggan depel
                JOIN user usr ON
                    depel.user_id = usr.user_id
                WHERE
                    depel.pelanggan_id = :pelanggan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("pelanggan_id", $pelangganId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTransaksiByPelangganId($pelanggan_id)
    {
        $query = "SELECT
                        *
                    FROM
                        detail_transaksi dt
                    JOIN transaksi trans ON
                        dt.no_transaksi = trans.no_transaksi
                    WHERE
                        trans.pelanggan_id = :pelanggan_id
                        AND (dt.status_transaksi IS NULL
                            OR dt.status_transaksi = 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("pelanggan_id", $pelanggan_id);
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

    $pelanggan = new Pelanggan();
    if ($_POST['action'] == 'add_pelanggan') {

        foreach ($_POST['data'] as $field => $value) {
            $data[$field] = $value;
        }

        $checkUser = $pelanggan->checkUser($data['username']);
        if ($checkUser) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh pelanggan lain', 'icon' => 'bx bx-error-circle']);
            exit;
        }

        $dataUser = [
            'username' => $data['username'],
            'password' => md5($data['password']),
            'role_id' => 2,
        ];
        $addUser = $pelanggan->addUser($dataUser);

        $dataPelanggan = [
            'nama_pelanggan' => $data['nama_pelanggan'],
            'no_hp' => $data['no_hp'],
            'alamat' => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'user_id' => $addUser
        ];
        $addPelanggan = $pelanggan->addPelanggan($dataPelanggan);

        if ($addPelanggan) {
            echo json_encode(['status' => 'success', 'message' => 'User dan pelanggan berhasil ditambahkan', 'icon' => 'bx bx-check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User dan pelanggan gagal ditambahkan', 'icon' => 'bx bx-error-circle']);
        }
    }

    if ($_POST['action'] == 'edit_pelanggan') {

        foreach ($_POST['data'] as $field => $value) {
            $data[$field] = $value;
        }


        $checkUser = $pelanggan->checkUser($data['username']);
        if ($checkUser) {
            if (intval($data['user_id']) != $checkUser['user_id']) {
                echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh pelanggan lain', 'icon' => 'bx bx-error-circle']);
                exit;
            }
        }

        $dataEditUser = [
            'username' => $data['username'],
        ];
        $updateUser = $pelanggan->updatePelanggan('user', $dataEditUser, ['user_id' => $data['user_id']]);

        $dataEditPelanggan = [
            'nama_pelanggan' => $data['nama_pelanggan'],
            'no_hp' => $data['no_hp'],
            'alamat' => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
        ];
        $updatePelanggan = $pelanggan->updatePelanggan('detail_pelanggan', $dataEditPelanggan, ['pelanggan_id' => $data['pelanggan_id']]);

        if ($updatePelanggan || $updateUser) {
            echo json_encode(['status' => 'success', 'message' => 'User dan pelanggan berhasil diubah', 'icon' => 'bx bx-check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User dan pelanggan gagal diubah', 'icon' => 'bx bx-error-circle']);
        }
    }

    if ($_POST['action'] == 'delete_pelanggan') {
        $checkTransaksi = $pelanggan->getTransaksiByPelangganId($_POST['pelanggan_id']);
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
            echo json_encode(['status' => 'info', 'message' => "Pelanggan tidak bisa dihapus karena masih memiliki transaksi dengan status <br> - Pending: $transPending <br> - Process: $transProcess", 'time' => 5000]);
            exit;
        } else {
            $editUser = $pelanggan->updatePelanggan('user', ['is_active' => 0], ['user_id' => $_POST['user_id']]);

            if ($editUser) {
                echo json_encode(['status' => 'success', 'message' => 'Pelanggan berhasil dihapus', 'time' => 2000]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Pelanggan gagal dihapus', 'time' => 2000]);
            }
        }
    }
}
