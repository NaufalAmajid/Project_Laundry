<?php

class Dashboard
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getDetailOrderByStatus()
    {
        $query = "select
                        count(case when dt.status_transaksi is null then dt.no_transaksi end) as order_pending,
                        count(case when dt.status_transaksi = 1 then dt.no_transaksi end) as order_proses,
                        count(case when dt.status_transaksi = 2 then dt.no_transaksi end) as order_selesai,
                        count(dt.no_transaksi) as total_order
                    from
                        transaksi trans
                    join detail_transaksi dt on
                        trans.no_transaksi = dt.no_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
