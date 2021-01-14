-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2021 at 09:11 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id_kas` int(11) NOT NULL,
  `jumlah_uang` int(11) NOT NULL,
  `posisi_kas` varchar(2) NOT NULL,
  `keterangan_kas` varchar(255) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id_kas`, `jumlah_uang`, `posisi_kas`, `keterangan_kas`, `id_pembelian`, `id_penjualan`, `tgl_input`) VALUES
(1, 256000000, 'K', 'penambahan', 8, 0, '2021-01-12 11:41:55'),
(2, 49050000, 'D', 'Penjualan', 0, 9, '2021-01-12 11:50:06'),
(3, 11700000, 'K', 'Beli  ', 9, 0, '2021-01-12 11:55:14'),
(4, 11700000, 'K', 'Beli  ', 10, 0, '2021-01-12 11:55:17'),
(6, 15000000, 'K', 'Beli 4 100', 12, 0, '2021-01-12 11:58:19'),
(7, 15000000, 'D', 'Bimoli 2L 100 Dus', 0, 11, '2021-01-12 13:30:47'),
(8, 11700000, 'K', 'Pembelian', 13, 0, '2021-01-12 13:36:23'),
(9, 11455000, 'K', 'KA Mix 200 ', 14, 0, '2021-01-12 13:37:25'),
(10, 15000000, 'K', 'Beli Bimoli 2L 100 Dus', 15, 0, '2021-01-12 13:38:20'),
(11, 11700000, 'D', 'Jual KA MIX 100 Dus', 0, 12, '2021-01-12 13:40:00'),
(12, 200000000, 'K', 'Beli Beli Susu Ultra Coklat Dari Warung Pintar', 16, 0, '2021-01-13 10:56:24'),
(13, 10000000, 'D', 'Jual ', 0, 13, '2021-01-14 13:40:21'),
(14, 10000000, 'D', 'Jual ', 0, 14, '2021-01-14 13:42:04'),
(15, 10000000, 'D', 'Jual ', 0, 15, '2021-01-14 13:45:18'),
(16, 10000000, 'D', 'Jual ', 0, 16, '2021-01-14 13:46:31'),
(17, 15000000, 'D', 'Jual ', 0, 17, '2021-01-14 13:47:45'),
(18, 10000000, 'D', 'Jual ', 0, 18, '2021-01-14 13:49:29'),
(19, 10000000, 'D', 'Jual Susu Ultra 100 Dus Ke Reni', 0, 19, '2021-01-14 13:51:43'),
(20, 7500000, 'D', 'Jual Bimoli 2L ke Berkah', 0, 20, '2021-01-14 13:52:42'),
(21, 10000000, 'D', 'Jual Susu Ultra 100 Dus Ke Berkah', 0, 21, '2021-01-14 13:53:33'),
(22, 15000000, 'K', 'Beli Bimoli 2L dari Warung Pintar', 17, 0, '2021-01-14 14:02:26'),
(23, 15000000, 'K', 'Beli Bimoli 2L 100 Dus Dari Warung Pintar', 18, 0, '2021-01-14 14:04:31'),
(24, 50000000, 'D', 'Jual Susu Ultra 500 Dus Ke Reni', 0, 22, '2021-01-14 15:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `kategori`, `tgl_input`) VALUES
(3, 'Makanan', '2021-01-11 14:54:08'),
(4, 'Minuman', '2021-01-11 14:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` set('Pria','Wanita','Lainya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `tgl_input`) VALUES
(3, 'Berkah', 'Pria', 'Jalan jalan', '7788994455', '2021-01-11 14:54:43'),
(4, 'Reni', 'Wanita', 'Jalan PKP', '081244445555', '2021-01-12 08:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `role`, `tgl_input`) VALUES
(1, 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Admin', '1', '2021-01-11 14:57:59'),
(3, 'mal', '$2y$10$tyuq0/jDKxkP2rdun3A/quy2Fugck2XFlL3KwPE19nnPh3fzIxzhq', 'Mal', '2', '2021-01-13 14:11:35');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` int(11) NOT NULL,
  `satuan` int(11) NOT NULL,
  `harga` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int(11) NOT NULL,
  `terjual` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama_produk`, `kategori`, `satuan`, `harga`, `stok`, `terjual`, `tgl_input`) VALUES
(3, 'Kapal Api Special Mix', 'Kapal Api Special Mix', 4, 3, '117500', 650, '100', '2021-01-11 14:58:22'),
(4, 'Bimoli 2L', 'Bimoli 2L', 3, 3, '150000', 550, '50', '2021-01-11 16:14:27'),
(5, 'Susu Ultra Coklat', 'Susu Ultra Coklat', 4, 3, '100000', 700, '500', '2021-01-13 10:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `satuan_produk`
--

CREATE TABLE `satuan_produk` (
  `id` int(11) NOT NULL,
  `satuan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_produk`
--

INSERT INTO `satuan_produk` (`id`, `satuan`, `tgl_input`) VALUES
(3, 'Dus', '2021-01-11 15:01:06'),
(4, 'Krat', '2021-01-11 15:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int(11) NOT NULL,
  `jumlah` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int(11) NOT NULL,
  `jumlah` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int(11) DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `metode_pembayaran` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `tanggal`, `barcode`, `jumlah`, `keterangan`, `supplier`, `harga`, `metode_pembayaran`) VALUES
(4, '2021-01-11 14:49:13', 3, '1000', 'penambahan', 3, 0, ''),
(5, '2021-01-11 16:14:32', 4, '700', 'penambahan', 3, 0, ''),
(6, '2021-01-12 08:26:38', 3, '200', 'penambahan', 3, 0, ''),
(7, '2021-01-12 08:56:05', 3, '100', 'penambahan', 3, 11600000, ''),
(8, '2021-01-12 11:41:28', 3, '200', 'penambahan', 3, 256000000, ''),
(12, '2021-01-12 11:58:07', 4, '100', 'penambahan', 3, 15000000, ''),
(13, '2021-01-12 13:35:37', 3, '100', 'Beli KA Mi', 3, 11700000, ''),
(14, '2021-01-12 13:36:59', 3, '200', 'KA Mix 200', 3, 11455000, ''),
(15, '2021-01-12 13:38:02', 4, '100', 'Bimoli 2L ', 3, 15000000, ''),
(16, '2021-01-13 10:55:41', 5, '2000', 'Beli Susu ', 3, 200000000, ''),
(17, '2021-01-14 14:01:01', 4, '100', 'Bimoli 2L ', 3, 15000000, 'cash'),
(18, '2021-01-14 14:03:36', 4, '100', 'Bimoli 2L ', 3, 15000000, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `telepon`, `keterangan`, `tgl_input`) VALUES
(3, 'Warung Pintar', 'warung', '112244557788', 'Oke', '2021-01-11 15:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `nama`, `alamat`) VALUES
(1, 'Sahabat Sembako', 'Jalan Persahabatan VI no 21');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bayar` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_uang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diskon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelanggan` int(11) DEFAULT NULL,
  `nota` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasir` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `barcode`, `qty`, `total_bayar`, `jumlah_uang`, `diskon`, `pelanggan`, `nota`, `kasir`, `keterangan`, `metode_pembayaran`) VALUES
(7, '2021-01-11 14:50:19', '3', '500', '58500000', '58500000', '', 3, 'UARH16YATJA4YV6', 1, '', ''),
(8, '2021-01-12 08:31:58', '3', '100', '11700000', '11700000', '', 4, 'X0P05UH5THD3U1F', 1, '', ''),
(9, '2021-01-12 11:49:54', '3,4', '210,150', '49050000', '49050000', '', 4, 'EY98HHJNNYCNLWM', 1, '', ''),
(10, '2021-01-12 13:25:03', '4', '90', '13500000', '13500000', '', 4, 'DOI6SG4VB209M5C', 1, '', ''),
(11, '2021-01-12 13:30:32', '4', '100', '15000000', '15000000', '', 4, 'ND4ENCVNW1QZFXD', 1, 'Bimoli 2L 100 Dus', ''),
(12, '2021-01-12 13:39:31', '3', '100', '11700000', '11700000', '', 3, '1G1OIS069WA2Z2E', 1, 'KA MIX 100 Dus', ''),
(13, '2021-01-14 13:39:47', '5', '100', '10000000', '10000000', '', 4, 'XWVLCFMQJP9OYLU', 1, '', '\n         '),
(14, '2021-01-14 13:41:27', '5', '100', '10000000', '10000000', '', 4, 'XCWBU97WLGHUD7G', 1, '', '\n         '),
(15, '2021-01-14 13:44:56', '5', '100', '10000000', '10000000', '', 3, 'IFZ6QAPIJ40G19W', 1, '', '\n         '),
(16, '2021-01-14 13:46:08', '5', '100', '10000000', '10000000', '', 4, '1HUWWMTXA2Y5DXT', 1, '', '\n         '),
(17, '2021-01-14 13:47:02', '4', '100', '15000000', '15000000', '', 3, '0VO766FWS3QY4FR', 1, '', '\n         '),
(18, '2021-01-14 13:49:01', '5', '100', '10000000', '10000000', '', 3, 'QU08F43MKPDKR2C', 1, '', 'cash'),
(19, '2021-01-14 13:51:16', '5', '100', '10000000', '10000000', '', 4, 'Q6TEG31ONFPNS84', 1, 'Susu Ultra 100 Dus Ke Reni', 'cash'),
(20, '2021-01-14 13:52:20', '4', '50', '7500000', '7500000', '', 3, '2ETHGLU3AXNSONE', 1, 'Bimoli 2L ke Berkah', 'transfer'),
(21, '2021-01-14 13:53:10', '5', '100', '10000000', '10000000', '', 3, 'QP2AB82CUZ9EGOP', 1, 'Susu Ultra 100 Dus Ke Berkah', 'transfer'),
(22, '2021-01-14 14:59:35', '5', '500', '50000000', '50000000', '', 4, 'NCVSEFPP5EWPL9R', 1, 'Susu Ultra 500 Dus Ke Reni', 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `uang`
--

CREATE TABLE `uang` (
  `id_uang` int(11) NOT NULL,
  `metode` varchar(10) NOT NULL,
  `jumlah_uang` varchar(255) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uang`
--

INSERT INTO `uang` (`id_uang`, `metode`, `jumlah_uang`, `tgl_input`, `tgl_update`) VALUES
(3, 'cash', '55000000', '2021-01-14 13:49:29', '2021-01-14 14:59:35'),
(4, 'transfer', '17500000', '2021-01-14 13:52:42', '2021-01-14 13:53:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uang`
--
ALTER TABLE `uang`
  ADD PRIMARY KEY (`id_uang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `uang`
--
ALTER TABLE `uang`
  MODIFY `id_uang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
