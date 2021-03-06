-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2021 at 08:52 AM
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
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id_invoice` int(11) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `total_bayar` varchar(15) NOT NULL,
  `jumlah_uang` varchar(15) NOT NULL,
  `diskon` varchar(15) NOT NULL,
  `pelanggan` int(11) NOT NULL,
  `nota` varchar(15) NOT NULL,
  `kasir` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `metode_pembayaran` varchar(10) NOT NULL,
  `status` varchar(1) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_edit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id_invoice`, `barcode`, `qty`, `total_bayar`, `jumlah_uang`, `diskon`, `pelanggan`, `nota`, `kasir`, `keterangan`, `metode_pembayaran`, `status`, `tanggal`, `tgl_edit`) VALUES
(14, '31548,77450', '100,200', '33000000', '33000000', '', 3, 'F5TVI7ZJDCD3EJV', 1, 'Jual Indomie Goreng 100 Dus & KA Mix 100 Dus ke Berkah', 'cash', '1', '2021-01-21 09:29:45', '2021-01-21 03:30:51'),
(15, '31548', '50', '5875000', '5875000', '', 3, 'IDLJEXY2YJFQA77', 1, 'Jual KA Mix 50 Dus ke Berkah', 'cash', '1', '2021-01-21 10:00:11', '2021-01-21 04:00:43'),
(16, '21647,31548,77450', '50,50,50', '18125000', '18125000', '', 3, 'AH19T8NQWJ0MVB8', 1, 'Jual Indo Goreng 50 Dus, Bimoli 2L 50 Dus, KA Mix 50 Dus ke Berkah', 'cash', '1', '2021-01-21 10:25:42', '2021-01-21 04:26:39'),
(17, '21647', '5', '500000', '', '', 4, 'NY0937DYSX3YXNJ', 4, '', 'cash', '0', '2021-01-26 10:44:20', NULL),
(18, '21647', '5', '300000', '300000', '', 3, 'QTW6B5U47YECRNM', 1, '', 'cash', '1', '2021-01-26 14:40:41', '2021-01-26 08:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `kartu_stok`
--

CREATE TABLE `kartu_stok` (
  `id_kartu_stok` int(11) NOT NULL,
  `id_produk` varchar(20) NOT NULL,
  `posisi` varchar(1) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kartu_stok`
--

INSERT INTO `kartu_stok` (`id_kartu_stok`, `id_produk`, `posisi`, `id_transaksi`, `qty`, `keterangan`, `tanggal`) VALUES
(19, '31548', 'D', 40, '1000', 'Beli Beli KA Mix 1000 Dus di Warpin', '2021-01-21 09:26:58'),
(20, '77450', 'D', 41, '500', 'Beli Beli Indomie Goreng 500 Dus di IDmarco', '2021-01-21 09:28:18'),
(21, '31548,77450', 'K', 63, '100,200', 'Jual Jual Indomie Goreng 100 Dus & KA Mix 100 Dus ke Berkah', '2021-01-21 09:30:51'),
(22, '31548,77450', 'K', 64, '100,100', 'Jual Jual Indomie Goreng 100 Dus dan KA Mix 100 Dus Ke Reni', '2021-01-21 09:55:48'),
(23, '31548', 'K', 65, '50', 'Jual Jual KA Mix 50 Dus ke Berkah', '2021-01-21 10:00:43'),
(24, '21647', 'D', 42, '200', 'Beli Beli Bimoli 2L ke Warpin', '2021-01-21 10:25:07'),
(25, '21647,31548,77450', 'K', 66, '50,50,50', 'Jual Jual Indo Goreng 50 Dus, Bimoli 2L 50 Dus, KA Mix 50 Dus ke Berkah', '2021-01-21 10:26:39'),
(26, '31548', 'K', 67, '50', 'Jual ', '2021-01-25 14:41:53'),
(27, '21647,50737', 'D', 43, '10,10', 'Beli Lunas', '2021-01-25 16:23:06'),
(28, '70696,50737', 'D', 44, '50,40', 'Beli ', '2021-01-26 09:07:03'),
(29, '50737,70696', 'D', 45, '60,60', 'Beli ', '2021-01-26 09:09:44'),
(30, '21647', 'D', 46, '10', 'Beli ', '2021-01-26 09:13:05'),
(31, '70696,50737', 'D', 47, '120,120', 'Beli ', '2021-01-26 09:20:32'),
(32, '21647', 'K', 68, '100', 'Jual Lunas', '2021-01-26 09:30:47'),
(33, '21647', 'K', 69, '5', 'Jual Lunas', '2021-01-26 10:43:44'),
(34, '50737', 'D', 48, '10', 'Beli ', '2021-01-26 10:47:12'),
(35, '21647', 'K', 70, '5', 'Jual ', '2021-01-26 14:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id_kas` int(11) NOT NULL,
  `jumlah_uang` int(11) NOT NULL,
  `metode_pembayaran` varchar(10) NOT NULL,
  `posisi_kas` varchar(2) NOT NULL,
  `keterangan_kas` varchar(255) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id_kas`, `jumlah_uang`, `metode_pembayaran`, `posisi_kas`, `keterangan_kas`, `id_pembelian`, `id_penjualan`, `tgl_input`) VALUES
(65, 116000000, 'cash', 'K', 'Beli Beli KA Mix 1000 Dus di Warpin', 40, 0, '2021-01-21 09:26:58'),
(66, 9200000, 'transfer', 'K', 'Beli Beli Indomie Goreng 500 Dus di IDmarco', 41, 0, '2021-01-21 09:28:18'),
(67, 33000000, 'cash', 'D', 'Jual Jual Indomie Goreng 100 Dus & KA Mix 100 Dus ke Berkah', 0, 63, '2021-01-21 09:30:51'),
(68, 21250000, 'cash', 'D', 'Jual Jual Indomie Goreng 100 Dus dan KA Mix 100 Dus Ke Reni', 0, 64, '2021-01-21 09:55:48'),
(69, 5875000, 'cash', 'D', 'Jual Jual KA Mix 50 Dus ke Berkah', 0, 65, '2021-01-21 10:00:43'),
(70, 14000000, 'cash', 'K', 'Beli Beli Bimoli 2L ke Warpin', 42, 0, '2021-01-21 10:25:07'),
(71, 18125000, 'cash', 'D', 'Jual Jual Indo Goreng 50 Dus, Bimoli 2L 50 Dus, KA Mix 50 Dus ke Berkah', 0, 66, '2021-01-21 10:26:39'),
(72, 5875000, 'cash', 'D', 'Jual ', 0, 67, '2021-01-25 14:41:53'),
(73, 2900000, 'cash', 'K', 'Beli Lunas', 43, 0, '2021-01-25 16:23:06'),
(74, 14500000, 'transfer', 'K', 'Beli ', 44, 0, '2021-01-26 09:07:03'),
(75, 18000000, 'cash', 'K', 'Beli ', 45, 0, '2021-01-26 09:09:44'),
(76, 1500000, 'cash', 'K', 'Beli ', 46, 0, '2021-01-26 09:13:05'),
(77, 37200000, 'cash', 'K', 'Beli ', 47, 0, '2021-01-26 09:20:32'),
(78, 25300000, 'cash', 'D', 'Jual Lunas', 0, 68, '2021-01-26 09:30:47'),
(79, 10000000, 'cash', 'D', 'Jual Lunas', 0, 69, '2021-01-26 10:43:44'),
(80, 600000, 'cash', 'K', 'Beli ', 48, 0, '2021-01-26 10:47:12'),
(81, 300000, 'cash', 'D', 'Jual ', 0, 70, '2021-01-26 14:41:15');

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
(5, 'Mie Instan', '2021-01-18 08:12:06'),
(6, 'Kopi', '2021-01-18 08:12:17'),
(7, 'Minyak', '2021-01-18 08:12:24'),
(8, 'Gula', '2021-01-18 08:12:31'),
(9, 'Air Mineral', '2021-01-18 08:12:50'),
(10, 'Susu', '2021-01-18 08:12:59'),
(11, 'Minuman berenergi', '2021-01-25 14:30:47'),
(12, 'gulaa', '2021-01-26 10:38:47');

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
(3, 'Berkah', 'Wanita', 'Jalan jalan', '7788994455', '2021-01-11 14:54:43'),
(4, 'Reni', 'Wanita', 'Jalan PKP', '081244445555', '2021-01-12 08:31:45'),
(6, 'Berkaha', 'Pria', 'Carefour Jakarta', '4124124124124', '2021-01-26 10:37:00');

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
(4, 'mal', '$2y$10$NovYJ.vPpqfRtE.iIvCDYeM75qqcuhvp.67IPPH51ELvspbEMy2VC', 'mal', '2', '2021-01-22 08:37:17'),
(5, 'firman', '$2y$10$l0SOzu3oygu566ik0eiT1ubTgMSaH5O9.ob5EqWA.WzD8WSwlDdOK', 'Firman', '3', '2021-01-22 08:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(20) NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` int(11) NOT NULL,
  `satuan` int(11) NOT NULL,
  `harga` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `stok` int(11) NOT NULL,
  `terjual` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama_produk`, `kategori`, `satuan`, `harga`, `stok`, `terjual`, `tgl_input`) VALUES
(21647, 'Bimoli 2L', 'Bimoli 2L', 7, 3, '0', 0, '10', '2021-01-21 10:24:25'),
(31548, 'Kopi Kapal Api Spc Mix', 'Kopi Kapal Api Spc Mix', 6, 3, '0', 640, '10', '2021-01-21 09:23:46'),
(50737, 'Mie Sakura', 'Mie Sakura', 5, 3, '0', 20, '', '2021-01-25 14:27:11'),
(70696, 'Bear Brand', 'Bear Brand', 10, 4, '0', 10, '', '2021-01-26 09:03:32'),
(77450, 'Indomie Goreng', 'Indomie Goreng', 5, 3, '0', 150, '150', '2021-01-21 09:26:16'),
(91320, 'Bimoli 2La', 'Bimoli 2La', 7, 3, '0', 0, '', '2021-01-26 10:41:47');

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
(4, 'Krat', '2021-01-11 15:01:06'),
(6, 'dusa', '2021-01-26 10:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `barcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int(11) DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `metode_pembayaran` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_nota` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `tanggal`, `barcode`, `jumlah`, `keterangan`, `supplier`, `harga`, `metode_pembayaran`, `no_nota`) VALUES
(40, '2021-01-21 09:26:24', '31548', '1000', 'Beli KA Mix 1000 Dus di Warpin', 3, 116000000, 'cash', ''),
(41, '2021-01-21 09:27:41', '77450', '500', 'Beli Indomie Goreng 500 Dus di IDmarco', 4, 9200000, 'transfer', ''),
(42, '2021-01-21 10:24:34', '21647', '200', 'Beli Bimoli 2L ke Warpin', 3, 14000000, 'cash', ''),
(43, '2021-01-25 16:22:49', '21647,50737', '10,10', 'Lunas', 3, 2900000, 'cash', ''),
(44, '2021-01-26 09:05:54', '70696,50737', '50,40', '', 3, 14500000, 'transfer', NULL),
(45, '2021-01-26 09:09:32', '50737,70696', '60,60', '', 4, 18000000, 'cash', NULL),
(46, '2021-01-26 09:12:55', '21647', '10', '', 3, 1500000, 'cash', NULL),
(47, '2021-01-26 09:20:24', '70696,50737', '120,120', '', 3, 37200000, 'cash', NULL),
(48, '2021-01-26 10:47:00', '50737', '10', '', 4, 600000, 'cash', NULL);

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
(3, 'Warung Pintar', 'warung', '112244557788', 'Oke', '2021-01-11 15:01:30'),
(4, 'Idmarco', 'Online', '02177889944', 'Oke', '2021-01-14 15:56:32');

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
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `barcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bayar` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(63, '2021-01-21 09:30:51', '31548,77450', '100,200', '33000000', '33000000', '', 3, 'F5TVI7ZJDCD3EJV', 1, 'Jual Indomie Goreng 100 Dus & KA Mix 100 Dus ke Berkah', 'cash'),
(64, '2021-01-21 09:55:17', '31548,77450', '100,100', '21250000', '21520000', '', 4, 'KK9F21T6DU3T3MW', 1, 'Jual Indomie Goreng 100 Dus dan KA Mix 100 Dus Ke Reni', 'cash'),
(65, '2021-01-21 10:00:43', '31548', '50', '5875000', '5875000', '', 3, 'IDLJEXY2YJFQA77', 1, 'Jual KA Mix 50 Dus ke Berkah', 'cash'),
(66, '2021-01-21 10:26:39', '21647,31548,77450', '50,50,50', '18125000', '18125000', '', 3, 'AH19T8NQWJ0MVB8', 1, 'Jual Indo Goreng 50 Dus, Bimoli 2L 50 Dus, KA Mix 50 Dus ke Berkah', 'cash'),
(67, '2021-01-25 14:41:36', '31548', '50', '5875000', '5875000', '', 4, 'RZR7UKQJLT9FMBH', 1, '', 'cash'),
(68, '2021-01-26 09:30:24', '21647', '100', '25300000', '25300000', '', 3, 'LG5ZEFP6H1V38P2', 1, 'Lunas', 'cash'),
(69, '2021-01-26 10:43:25', '21647', '5', '10000000', '10000000', '', 4, '4ZI6X8ANRUDUTRT', 4, 'Lunas', 'cash'),
(70, '2021-01-26 14:41:15', '21647', '5', '300000', '300000', '', 3, 'QTW6B5U47YECRNM', 1, '', 'cash');

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
(18, 'cash', '-70205000', '2021-01-21 09:26:58', '2021-01-26 08:41:15'),
(19, 'transfer', '-23700000', '2021-01-21 09:28:18', '2021-01-26 09:05:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indexes for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  ADD PRIMARY KEY (`id_kartu_stok`);

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
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  MODIFY `id_kartu_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `uang`
--
ALTER TABLE `uang`
  MODIFY `id_uang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
