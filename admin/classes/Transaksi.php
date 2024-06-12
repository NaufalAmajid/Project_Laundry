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
}
