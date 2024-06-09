<?php

class Login
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function login($data)
    {
        $password = md5($data['password']);

        $query = "SELECT
                        CASE
                            WHEN dpem.pemilik_id IS NULL THEN dpel.pelanggan_id
                            ELSE dpem.pemilik_id
                        END AS the_id,
                        CASE
                            WHEN dpem.pemilik_id IS NULL THEN dpel.nama_pelanggan
                            ELSE dpem.nama_pemilik
                        END AS nama,
                        usr.user_id,
                        usr.username,
                        ru.role_id,
                        ru.nama_role 
                    FROM
                        user usr
                    LEFT JOIN role_user ru ON
                        usr.role_id = ru.role_id
                    LEFT JOIN detail_pemilik dpem ON
                        usr.user_id = dpem.user_id
                    LEFT JOIN detail_pelanggan dpel ON
                        usr.user_id = dpel.user_id
                    WHERE
                        usr.username = '$data[username]'
                        AND usr.password = '$password'
                        AND usr.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';
    $login = new Login();

    if ($_POST['action'] == 'login') {

        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
        ];

        $login = $login->login($data);

        if ($login) {
            session_start();
            $_SESSION['user_id'] = $login['user_id'];
            $_SESSION['role_id'] = $login['role_id'];
            $_SESSION['nama_role'] = $login['nama_role'];
            $_SESSION['username'] = $login['username'];
            $_SESSION['nama'] = $login['nama'];
            $_SESSION['is_login'] = true;

            echo json_encode(['status' => 'success', 'msg' => 'Login berhasil']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Username atau password salah']);
        }
    }

    if ($_POST['action'] == 'logout') {
        session_start();
        session_destroy();
        echo json_encode(['status' => 'success', 'msg' => 'Logout berhasil']);
    }
}
