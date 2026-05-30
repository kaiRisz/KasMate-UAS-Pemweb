-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2026 at 03:38 PM
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
-- Database: `kasmate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `id_grup` int NOT NULL,
  `nama_grup` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `id_bendahara` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id_grup`, `nama_grup`, `deskripsi`, `id_bendahara`) VALUES
(6, 'Kelas Matematika', 'kas', 16),
(7, 'KELAS IPA', 'KAS', 16);

-- --------------------------------------------------------

--
-- Table structure for table `grup_anggota`
--

CREATE TABLE `grup_anggota` (
  `id_grup_anggota` int NOT NULL,
  `id_grup` int DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grup_anggota`
--

INSERT INTO `grup_anggota` (`id_grup_anggota`, `id_grup`, `id_user`) VALUES
(10, 6, 15),
(11, 7, 15);

-- --------------------------------------------------------

--
-- Table structure for table `iuran`
--

CREATE TABLE `iuran` (
  `id_iuran` int NOT NULL,
  `id_grup` int DEFAULT NULL,
  `nama_iuran` varchar(100) DEFAULT NULL,
  `nominal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `iuran`
--

INSERT INTO `iuran` (`id_iuran`, `id_grup`, `nama_iuran`, `nominal`) VALUES
(3, 6, 'Iuran baru', 5000),
(4, 7, 'Iuran baru', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan_kas`
--

CREATE TABLE `pemasukan_kas` (
  `id_pemasukan` int NOT NULL,
  `id_grup` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `nominal` int DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_iuran` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `status` enum('Lunas','Belum Lunas') DEFAULT 'Belum Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_iuran`, `id_user`, `tanggal_bayar`, `status`) VALUES
(9, 3, 15, '2026-05-29', 'Lunas'),
(10, 4, 15, '2026-05-29', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int NOT NULL,
  `id_grup` int DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `nominal_keluar` int DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','bendahara','user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`) VALUES
(15, 'Faqih', 'faqih@gmail.com', '$2y$10$XNiOcmXekUwZMwAEPs/Px.2EZAk.kMm1CUT1O86QrCARBZ/uwHRVy', 'user'),
(16, 'Atha', 'Atha@gmail.com', '$2y$10$CEbN2MzrsGMk/6mfeXXxo.0zuCs8LHydghYtcP0OY8lceBZ2CcyG.', 'bendahara'),
(17, 'adminn', 'adminn@gmai.com', '$2y$10$gGdDULyn3/57DOY.XozOiu2g9F9RQ4/wKPNWie9C7ce8Fe0vjf6b6', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`id_grup`),
  ADD KEY `id_bendahara` (`id_bendahara`);

--
-- Indexes for table `grup_anggota`
--
ALTER TABLE `grup_anggota`
  ADD PRIMARY KEY (`id_grup_anggota`),
  ADD KEY `id_grup` (`id_grup`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `iuran`
--
ALTER TABLE `iuran`
  ADD PRIMARY KEY (`id_iuran`),
  ADD KEY `id_grup` (`id_grup`);

--
-- Indexes for table `pemasukan_kas`
--
ALTER TABLE `pemasukan_kas`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `id_grup` (`id_grup`),
  ADD KEY `fk_pemasukan_user` (`id_user`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_iuran` (`id_iuran`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `id_grup` (`id_grup`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id_grup` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grup_anggota`
--
ALTER TABLE `grup_anggota`
  MODIFY `id_grup_anggota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `iuran`
--
ALTER TABLE `iuran`
  MODIFY `id_iuran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pemasukan_kas`
--
ALTER TABLE `pemasukan_kas`
  MODIFY `id_pemasukan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grup`
--
ALTER TABLE `grup`
  ADD CONSTRAINT `grup_ibfk_1` FOREIGN KEY (`id_bendahara`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `grup_anggota`
--
ALTER TABLE `grup_anggota`
  ADD CONSTRAINT `grup_anggota_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id_grup`),
  ADD CONSTRAINT `grup_anggota_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `iuran`
--
ALTER TABLE `iuran`
  ADD CONSTRAINT `iuran_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id_grup`);

--
-- Constraints for table `pemasukan_kas`
--
ALTER TABLE `pemasukan_kas`
  ADD CONSTRAINT `fk_pemasukan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `pemasukan_kas_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id_grup`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_iuran`) REFERENCES `iuran` (`id_iuran`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id_grup`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
