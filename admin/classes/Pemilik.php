<?php
date_default_timezone_set('Asia/Jakarta');

class Pemilik
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
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

    public function getAllPemilikById($pemilik_id)
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
}
