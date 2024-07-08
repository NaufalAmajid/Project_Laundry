<?php

class Laporan
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getLaporan($data)
    {
        $no_transaksi = $data['no_transaksi'];
        $first_date = $data['first_date'];
        $second_date = $data['second_date'];
        $nama_pelanggan = isset($data['nama_pelanggan']) ? $data['nama_pelanggan'] : '';
        $nama_jasa = isset($data['nama_jasa']) ? $data['nama_jasa'] : '';
        $query = "SELECT
                        date_format(rt.transaksi_date, '%Y-%m-%d') AS tgl_trans,
                        date_format(rt.transaksi_done, '%Y-%m-%d') AS tgl_selesai,
                        rt.*
                    FROM
                        riwayat_transaksi rt
                    WHERE
                        CAST(rt.transaksi_date AS date) BETWEEN '$first_date' AND '$second_date'
                        AND
                        rt.nama_pelanggan LIKE '%$nama_pelanggan%'
                        AND
                        rt.nama_jasa LIKE '%$nama_jasa%'
                        AND
                        rt.no_transaksi LIKE '%$no_transaksi%'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getPelangganByHistory()
    {
        $query = "SELECT
                        DISTINCT(rt.nama_pelanggan) AS nama_pelanggan
                    FROM
                        riwayat_transaksi rt";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getJasaByHistory()
    {
        $query = "SELECT
                        DISTINCT(rt.nama_jasa) AS nama_jasa
                    FROM
                        riwayat_transaksi rt";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
