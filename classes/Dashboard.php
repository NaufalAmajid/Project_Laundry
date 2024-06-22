<?php

class Dashboard
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getDetailOrderByStatus($pelanggan_id = null)
    {
        if (is_null($pelanggan_id)) {
            $where = "";
        } else {
            $where = "where trans.pelanggan_id = $pelanggan_id";
        }

        $query = "select
                        count(case when dt.status_transaksi is null then dt.no_transaksi end) as order_pending,
                        count(case when dt.status_transaksi = 1 then dt.no_transaksi end) as order_proses,
                        count(case when dt.status_transaksi = 2 then dt.no_transaksi end) as order_selesai,
                        count(dt.no_transaksi) as total_order
                    from
                        transaksi trans
                    join detail_transaksi dt on
                        trans.no_transaksi = dt.no_transaksi
                    $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountUser()
    {
        $query = "SELECT
                        COUNT(CASE WHEN role_id = 2 THEN user_id END) AS jumlah_pelanggan,
                        COUNT(CASE WHEN role_id = 1 THEN user_id END) AS jumlah_pemilik 
                    FROM
                        user
                    WHERE
                        is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountJasa()
    {
        $query = "SELECT
                        COUNT(jasa_id) AS jumlah_jasa
                    FROM
                        daftar_jasa
                    WHERE
                        is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountTransaksi()
    {
        $query = "SELECT 
                        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) AS jumlah_transaksi_hari_ini,
                        COUNT(CASE WHEN YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) AS jumlah_transaksi_minggu_ini,
                        COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN 1 END) AS jumlah_transaksi_bulan_ini
                    FROM transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPendapatan($year)
    {
        $query = "SELECT
                    c.bulan,
                    COALESCE(SUM(1000 * dt.jumlah), 0) AS total_pendapatan
                FROM
                    calendar c
                LEFT JOIN 
                    detail_transaksi dt
                    ON
                    c.bulan = MONTH(dt.created_at)
                    AND YEAR(dt.created_at) = :year
                    AND dt.status_transaksi = 2
                LEFT JOIN daftar_jasa dj ON
                    dt.jasa_id = dj.jasa_id
                GROUP BY
                    c.bulan
                ORDER BY
                    c.bulan ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();

        $pendapatan = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pendapatan[] = $row['total_pendapatan'];
        }
        return $pendapatan;
    }

    public function getYear()
    {
        $query = "SELECT
                    YEAR(created_at) AS year
                FROM
                    transaksi
                GROUP BY
                    YEAR(created_at)
                ORDER BY
                    YEAR(created_at) DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/connection.php';
    require_once '../classes/DB.php';

    $dashboard = new Dashboard();
    if ($_POST['action'] == 'get_pendapatan') {
        $year = isset($_POST['year']) ? $_POST['year'] : date('Y');
        $pendapatan = $dashboard->getPendapatan($year);
        echo json_encode($pendapatan);
    }
}
