<?php
define('FPDF_FONTPATH', 'fpdf/font/');
require_once 'fpdf/fpdf.php';
require_once '../config/connection.php';
require_once '../config/functions.php';
require_once '../classes/DB.php';
require_once '../classes/Transaksi.php';
require_once '../classes/Pengaturan.php';
date_default_timezone_set('Asia/Jakarta');

class PDF extends FPDF
{

    //Page header
    function Header()
    {
        $set = new Pengaturan();
        $set = $set->getPengaturan();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(19.1, 0.5, strtoupper($set['nama_usaha']), 0, 1, 'C');
        $this->Cell(19.1, 0.5, strtoupper($set['alamat']), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(19.1, 0.5, 'Telp. ' . $set['no_telepon'] . ' || Email. ' . $set['email'], 0, 1, 'C');
        $this->Ln(0.2);
        $this->Line(1, 2.5, 20, 2.5);
        $this->Line(1, 2.55, 20, 2.55);

        //Biodata
        $this->Ln(0.1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(19, 0.5, 'NOTA LAUNDRY', 0, 0, 'C');

        $desc = new Transaksi();
        $func = new Functions();
        $desc = $desc->getDescriptionTrans($_GET['notrans']);
        //Nama Pelanggan 
        $this->Ln(0.7);
        $this->SetFont('Arial', '', 10);
        $this->Cell(2, 0.5, 'Nama', 0, 0, 'L');
        $this->Cell(1, 0.5, ':', 0, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(8.5, 0.5, ucwords($desc['nama_pelanggan']), 0, 0);
        //No Transaksi
        $this->SetFont('Arial', '', 10);
        $this->Cell(2.5, 0.5, 'No. Transaksi', 0, 0);
        $this->Cell(1, 0.5, ':', 0, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.5, $desc['no_transaksi'], 0, 0);

        //Alamat Pelanggan
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(2, 0.5, 'Alamat', 0, 0, 'L');
        $this->Cell(1, 0.5, ':', 0, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(8.5, 0.5, $desc['alamat'], 0, 0);
        //Tgl Transaksi
        $this->SetFont('Arial', '', 10);
        $this->Cell(2.5, 0.5, 'Tanggal Transaksi', 0, 0);
        $this->Cell(1, 0.5, ':', 0, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.5, $func->dateIndonesia($desc['tgl_trans']), 0, 0);

        //No HP Pelanggan
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(2, 0.5, 'No Hp', 0, 0, 'L');
        $this->Cell(1, 0.5, ':', 0, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(8.5, 0.5, $desc['no_hp'], 0, 0);

        $this->Ln(0.3);
    }

    function Content()
    {
        $this->SetFont('Arial', '', 10);
        $this->Ln();
        $this->Cell(1, 0.5, 'No', 1, 0, 'C');
        $this->Cell(9, 0.5, 'Layanan', 1, 0, 'C');
        $this->Cell(3, 0.5, 'Harga Satuan', 1, 0, 'C');
        $this->Cell(3, 0.5, 'Jumlah / Berat', 1, 0, 'C');
        $this->Cell(3, 0.5, 'Total', 1, 0, 'C');

        //data transaksi
        $this->Ln(0.1);
        $no = 1;
        $totalAll = 0;
        $func = new Functions();
        $transaksi = new Transaksi();
        $trans = $transaksi->getTransaksiByNo($_GET['notrans']);
        foreach ($trans as $tr) {
            $this->Ln(0.7);
            $this->Cell(1, 0.5, $no++, 0, 0, 'C');
            $this->Cell(9, 0.5, $tr['nama_jasa'], 0, 0, 'L');
            $this->Cell(3, 0.5, $func->currency($tr['harga_satuan']), 0, 0, 'C');
            $this->Cell(3, 0.5, $tr['jumlah'], 0, 0, 'C');
            $this->Cell(3, 0.5, $func->currency($tr['total']), 0, 0, 'C');
            $totalAll += $tr['total'];
        }
        $this->Line(1, $this->GetY() + 0.7, 20, $this->GetY() + 0.7);

        $this->Ln(1);
        $this->MultiCell(10, 0.5, $func->spill($totalAll), 0, 'L');
        $this->SetXY($this->GetX() + 10, $this->GetY() - 0.5);
        $this->Cell(6, 0.5, 'Total Pembayaran :', 0, 0, 'R');
        $this->Cell(3, 0.5, $func->currency($totalAll), 0, 0, 'C');
        $this->Ln(2);
        $desc = $transaksi->getDescriptionTrans($_GET['notrans']);
        $this->Cell(10, 0.5, ucwords($desc['nama_pemilik']), 0, 0, 'C');
    }
}

$desc = new Transaksi();
$desc = $desc->getDescriptionTrans($_GET['notrans']);
if ($desc) {
    $pdf = new PDF('L', 'cm', array(21, 16.51));
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 0.2);
    $pdf->AddPage();
    $pdf->Content();
    $pdf->Output();
} else {
    echo "<script>alert('Belum Ada Transaksi!');window.close()</script>";
}
