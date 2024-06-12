<?php

class Transaksi
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getAllJasa()
    {
        $query = "SELECT * FROM daftar_jasa WHERE is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $jasa = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $jasa[] = $row;
        }

        return $jasa;
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
