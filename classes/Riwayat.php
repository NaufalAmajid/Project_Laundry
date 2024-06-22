<?php

class Riwayat
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }

    public function getRiwayat($data)
    {
        $first_date = $data['first_date'];
        $second_date = $data['second_date'];
        $pelanggan_id = $data['pelanggan_id'];
        $no_transaksi = isset($data['no_transaksi']) ? $data['no_transaksi'] : '';
        $query = "SELECT
                    trans.no_transaksi,
                    trans.status_transaksi,
                    dp.nama_pemilik,
                    date_format(trans.created_at, '%Y-%m-%d') AS tgl_trans,
                    COUNT(dt.jasa_id) AS jumlah_jasa,
                    SUM(dt.jumlah * dj.harga_satuan) AS total
                FROM
                    transaksi trans
                JOIN detail_transaksi dt ON
                    trans.no_transaksi = dt.no_transaksi
                JOIN detail_pemilik dp ON
                    dp.pemilik_id = trans.pemilik_id
                JOIN daftar_jasa dj ON
                    dt.jasa_id = dj.jasa_id
                WHERE
                    trans.pelanggan_id = $pelanggan_id
                    AND CAST(dt.created_at AS DATE) BETWEEN '$first_date' AND '$second_date'
                    AND trans.no_transaksi LIKE '%$no_transaksi%'
                GROUP BY
                    trans.no_transaksi,
                    trans.status_transaksi,
                    dp.nama_pemilik
                ORDER BY
                    trans.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
