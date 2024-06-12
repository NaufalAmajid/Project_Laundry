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
}
