<?php
date_default_timezone_set('Asia/Jakarta');

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function updateUser($table, $data, $where)
    {
        $db = DB::getInstance();
        $res = $db->update($table, $data, $where);
        return $res;
    }

    public function checkUser($username, $role_id)
    {
        $query = "SELECT * FROM user WHERE username = :username AND is_active = 1 AND role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetailUser($id, $role_id)
    {
        if ($role_id == 1) {
            $query = "select
                        dp.nama_pemilik as nama_user,
                        dp.*,
                        usr.*
                    from
                        detail_pemilik dp
                    join user usr on
                        dp.user_id = usr.user_id
                    where
                        dp.user_id = :id";
        } else {
            $query = "select
                        dp.nama_pelanggan as nama_user,
                        dp.*,
                        usr.*
                    from
                        detail_pelanggan dp
                    join user usr on
                        dp.user_id = usr.user_id
                    where
                        dp.user_id = :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkPassword($id, $password)
    {
        $query = "select
                    password
                from
                    user
                where
                    user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return md5($password) == $row['password'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $user = new User();
    if ($_POST['action'] == 'check-password') {
        $check = $user->checkPassword($_POST['user_id'], $_POST['password']);
        if ($check) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    if ($_POST['action'] == 'edit_user') {
        foreach ($_POST['data'] as $field => $value) {
            $data[$field] = $value;
        }

        $checkUser = $user->checkUser($data['username'], $data['role_id']);
        if ($checkUser) {
            if (intval($data['user_id']) != $checkUser['user_id']) {
                echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh user lain', 'icon' => 'bx bx-error-circle']);
                exit;
            }
        }

        if (isset($data['password']) && $data['password'] != '') {
            $updateUser = [
                'username' => $data['username'],
                'password' => md5($data['change_password1']),
            ];
            $editUser = $user->updateUser('user', $updateUser, ['user_id' => $data['user_id']]);
        } else {
            $updateUser = [
                'username' => $data['username'],
            ];
            $editUser = $user->updateUser('user', $updateUser, ['user_id' => $data['user_id']]);
        }

        if ($data['role_id'] == 1) {
            $updatePemilik = [
                'nama_pemilik' => $data['nama_user'],
            ];
            $editDetailUser = $user->updateUser('detail_pemilik', $updatePemilik, ['pemilik_id' => $data['the_id']]);
        } else {
            $updatePelanggan = [
                'nama_pelanggan' => $data['nama_user'],
                'alamat' => $data['alamat'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_hp' => $data['no_hp'],
            ];
            $editDetailUser = $user->updateUser('detail_pelanggan', $updatePelanggan, ['pelanggan_id' => $data['the_id']]);
        }

        if ($editUser || $editDetailUser) {
            session_start();
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama_user'];
            echo json_encode(['status' => 'success', 'message' => 'User berhasil diupdate', 'icon' => 'bx bx-check-circle']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User gagal diupdate', 'icon' => 'bx bx-error-circle']);
        }
    }
}
