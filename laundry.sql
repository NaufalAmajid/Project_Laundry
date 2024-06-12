-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: my_db
-- Waktu pembuatan: 12 Jun 2024 pada 00.31
-- Versi server: 11.4.2-MariaDB-ubu2404
-- Versi PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_jasa`
--

CREATE TABLE `daftar_jasa` (
  `jasa_id` int(11) NOT NULL,
  `nama_jasa` varchar(100) DEFAULT NULL,
  `harga_satuan` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `daftar_jasa`
--

INSERT INTO `daftar_jasa` (`jasa_id`, `nama_jasa`, `harga_satuan`, `is_active`) VALUES
(1, 'Laundry Reguler', 3500, 1),
(2, 'Cuci Sepatu', 7000, 1),
(3, 'Laundry Express', 5000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detaill_transaksi`
--

CREATE TABLE `detaill_transaksi` (
  `id` int(11) NOT NULL,
  `no_transaksi` varchar(100) DEFAULT NULL,
  `jasa_id` int(11) NOT NULL,
  `jumlah` varchar(10) DEFAULT NULL,
  `status_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pelanggan`
--

CREATE TABLE `detail_pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pelanggan`
--

INSERT INTO `detail_pelanggan` (`pelanggan_id`, `user_id`, `nama_pelanggan`, `alamat`, `jenis_kelamin`, `no_hp`) VALUES
(1, 1, 'Kirigaya Kazuto', 'Sukoharjo', 'Laki-laki', '085283901234'),
(2, 3, 'Yuki Asuna', 'Solo', 'Perempuan', '087526388912');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pemilik`
--

CREATE TABLE `detail_pemilik` (
  `pemilik_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pemilik`
--

INSERT INTO `detail_pemilik` (`pemilik_id`, `user_id`, `nama_pemilik`) VALUES
(1, 2, 'Kayaba Akihiko');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(4, 1, 3),
(5, 1, 5),
(6, 2, 4),
(7, 1, 6),
(8, 1, 7),
(9, 2, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `nama_menu` varchar(20) DEFAULT NULL,
  `direktori` varchar(20) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu_id`, `nama_menu`, `direktori`, `icon`) VALUES
(1, 'master', 'master', 'bx bx-data fs-4'),
(3, 'transaksi', 'transaksi', 'bx bx-credit-card fs-4'),
(4, 'riwayat transaksi', 'riwayat_transaksi', 'bx bx-book-bookmark fs-4'),
(5, 'pengaturan', 'pengaturan', 'bx bx-cog fs-4'),
(6, 'laporan', 'laporan', 'bx bx-history fs-4'),
(7, 'profile', 'profile', 'bx bx-user fs-4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_transaksi`
--

CREATE TABLE `riwayat_transaksi` (
  `id` int(11) NOT NULL,
  `no_transaksi` varchar(100) DEFAULT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `nama_jasa` varchar(100) DEFAULT NULL,
  `harga_satuan` int(11) DEFAULT NULL,
  `jumlah` varchar(10) DEFAULT NULL,
  `status_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `nama_role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role_user`
--

INSERT INTO `role_user` (`role_id`, `nama_role`) VALUES
(1, 'pemilik'),
(2, 'pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submenu`
--

CREATE TABLE `submenu` (
  `submenu_id` int(11) NOT NULL,
  `nama_submenu` varchar(20) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `direktori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `submenu`
--

INSERT INTO `submenu` (`submenu_id`, `nama_submenu`, `menu_id`, `direktori`) VALUES
(1, 'daftar jasa', 1, 'daftar_jasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `no_transaksi` varchar(100) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `pemilik_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role_id`, `is_active`) VALUES
(1, 'kirito', '202cb962ac59075b964b07152d234b70', 2, 1),
(2, 'kayaba', '202cb962ac59075b964b07152d234b70', 1, 1),
(3, 'asuna', '202cb962ac59075b964b07152d234b70', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_jasa`
--
ALTER TABLE `daftar_jasa`
  ADD PRIMARY KEY (`jasa_id`);

--
-- Indeks untuk tabel `detaill_transaksi`
--
ALTER TABLE `detaill_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detaill_transaksi_transaksi_FK` (`no_transaksi`),
  ADD KEY `detaill_transaksi_daftar_jasa_FK` (`jasa_id`);

--
-- Indeks untuk tabel `detail_pelanggan`
--
ALTER TABLE `detail_pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD KEY `detail_pelanggan_user_FK` (`user_id`);

--
-- Indeks untuk tabel `detail_pemilik`
--
ALTER TABLE `detail_pemilik`
  ADD PRIMARY KEY (`pemilik_id`),
  ADD KEY `detail_pemilik_user_FK` (`user_id`);

--
-- Indeks untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hak_akses_role_user_FK` (`role_id`),
  ADD KEY `hak_akses_menu_FK` (`menu_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`submenu_id`),
  ADD KEY `submenu_menu_FK` (`menu_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD UNIQUE KEY `transaksi_unique` (`no_transaksi`),
  ADD KEY `transaksi_detail_pelanggan_FK` (`pelanggan_id`),
  ADD KEY `transaksi_detail_pemilik_FK` (`pemilik_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role_user_FK` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_jasa`
--
ALTER TABLE `daftar_jasa`
  MODIFY `jasa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detaill_transaksi`
--
ALTER TABLE `detaill_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_pelanggan`
--
ALTER TABLE `detail_pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_pemilik`
--
ALTER TABLE `detail_pemilik`
  MODIFY `pemilik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role_user`
--
ALTER TABLE `role_user`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `submenu`
--
ALTER TABLE `submenu`
  MODIFY `submenu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detaill_transaksi`
--
ALTER TABLE `detaill_transaksi`
  ADD CONSTRAINT `detaill_transaksi_daftar_jasa_FK` FOREIGN KEY (`jasa_id`) REFERENCES `daftar_jasa` (`jasa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detaill_transaksi_transaksi_FK` FOREIGN KEY (`no_transaksi`) REFERENCES `transaksi` (`no_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pelanggan`
--
ALTER TABLE `detail_pelanggan`
  ADD CONSTRAINT `detail_pelanggan_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pemilik`
--
ALTER TABLE `detail_pemilik`
  ADD CONSTRAINT `detail_pemilik_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD CONSTRAINT `hak_akses_menu_FK` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hak_akses_role_user_FK` FOREIGN KEY (`role_id`) REFERENCES `role_user` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `submenu_menu_FK` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_detail_pelanggan_FK` FOREIGN KEY (`pelanggan_id`) REFERENCES `detail_pelanggan` (`pelanggan_id`),
  ADD CONSTRAINT `transaksi_detail_pemilik_FK` FOREIGN KEY (`pemilik_id`) REFERENCES `detail_pemilik` (`pemilik_id`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_user_FK` FOREIGN KEY (`role_id`) REFERENCES `role_user` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
