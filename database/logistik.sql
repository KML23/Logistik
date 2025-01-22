-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2025 at 03:39 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistik`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int NOT NULL,
  `id_order` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_hitam_barang`
--

CREATE TABLE `daftar_hitam_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int DEFAULT '0',
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id`, `nama_barang`, `stok`, `harga`, `created_at`) VALUES
(1, 'Kursi', 100, 500000.00, '2025-01-20 18:24:18'),
(3, 'Papan Tulis', 10, 750000.00, '2025-01-20 18:33:25'),
(12, 'Meja', 500, 575000.00, '2025-01-20 19:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `db_menu`
--

CREATE TABLE `db_menu` (
  `id` int NOT NULL,
  `sub_id` int NOT NULL,
  `nama_menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `link_page` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `modul` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `faicon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urutan` int NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data Menu' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `db_user`
--

CREATE TABLE `db_user` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_pegawai` int NOT NULL,
  `level_user` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1:aktif, 2:tidak_aktif',
  `hapus` int NOT NULL DEFAULT '0' COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Data User' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user`
--

INSERT INTO `db_user` (`id`, `username`, `no_telp`, `password`, `nama_user`, `id_pegawai`, `level_user`, `status`, `hapus`, `tgl_insert`, `tgl_update`, `user_update`) VALUES
(1, 'admin', '08123456789', '$2y$12$AUuZSYvW3V/qf23LLpY1/OXQoiPWu1D15m18Xaz5P2xm7z/X2mJXS', 'admin', 123, 1, 1, 0, '2025-01-21 09:57:58', '2025-01-21 02:57:58', '2025-01-21 02:57:58'),
(2, 'user', '08987654321', '$2y$12$a8L/ilwuZNOtIy4qb9DFauucZ07GJFcSuBo6YZaT29aygt9P0omDK', 'user', 321, 2, 1, 0, '2025-01-21 16:23:05', '2025-01-21 09:23:05', '2025-01-21 09:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `db_user_akses`
--

CREATE TABLE `db_user_akses` (
  `id` int NOT NULL,
  `id_level` int NOT NULL,
  `id_menu` int NOT NULL,
  `hk_add` int NOT NULL,
  `hk_edit` int NOT NULL,
  `hk_delete` int NOT NULL,
  `status` int NOT NULL,
  `hapus` int NOT NULL,
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Hak Akses User' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `db_user_level`
--

CREATE TABLE `db_user_level` (
  `id` int NOT NULL,
  `nama_level` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1:aktif, tidak aktif',
  `hapus` int NOT NULL DEFAULT '0' COMMENT '0:ada, 1:hapus',
  `tgl_insert` datetime NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_update` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Level User' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `distribusi_barang`
--

CREATE TABLE `distribusi_barang` (
  `id` int NOT NULL,
  `id_permintaan` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_distribusi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int NOT NULL,
  `nama_jenis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_barang`
--

CREATE TABLE `order_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_order` date DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `tanggal_permintaan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname_barang`
--

CREATE TABLE `stok_opname_barang` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `stok_aktual` int NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$12$KvcRscfpsauMJuMXKr0NGuVhrEuX5AAso1wNF2jVdEgOlS/UbX.l6', '2025-01-20 04:09:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_menu`
--
ALTER TABLE `db_menu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user_akses`
--
ALTER TABLE `db_user_akses`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user_level`
--
ALTER TABLE `db_user_level`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permintaan` (`id_permintaan`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_barang`
--
ALTER TABLE `order_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `db_menu`
--
ALTER TABLE `db_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_user`
--
ALTER TABLE `db_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `db_user_akses`
--
ALTER TABLE `db_user_akses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_user_level`
--
ALTER TABLE `db_user_level`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_barang`
--
ALTER TABLE `order_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `order_barang` (`id`);

--
-- Constraints for table `daftar_hitam_barang`
--
ALTER TABLE `daftar_hitam_barang`
  ADD CONSTRAINT `daftar_hitam_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);

--
-- Constraints for table `distribusi_barang`
--
ALTER TABLE `distribusi_barang`
  ADD CONSTRAINT `distribusi_barang_ibfk_1` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`);

--
-- Constraints for table `order_barang`
--
ALTER TABLE `order_barang`
  ADD CONSTRAINT `order_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);

--
-- Constraints for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD CONSTRAINT `permintaan_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);

--
-- Constraints for table `stok_opname_barang`
--
ALTER TABLE `stok_opname_barang`
  ADD CONSTRAINT `stok_opname_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
