-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 08:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nusantara`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id_album` int(10) NOT NULL,
  `nama_album` varchar(255) NOT NULL,
  `tanggal_rilis` date NOT NULL,
  `asal_daerah` varchar(255) NOT NULL,
  `sampul_album` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `nama_album`, `tanggal_rilis`, `asal_daerah`, `sampul_album`) VALUES
(24, 'Juicy Lucy', '2002-12-12', 'Jakarta', '202209230848-main.cropped_1663897735.jpeg'),
(25, 'cc', '1222-12-31', 'ca', 'd0181463de8046df80addd7f2ef46345_464_464.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `bootstrap_tb`
--

CREATE TABLE `bootstrap_tb` (
  `id` int(10) NOT NULL,
  `Nama_pengguna` varchar(255) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Kata_sandi` varchar(255) NOT NULL,
  `Foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bootstrap_tb`
--

INSERT INTO `bootstrap_tb` (`id`, `Nama_pengguna`, `Nama`, `Email`, `Kata_sandi`, `Foto`) VALUES
(5, 'raihan', 'raihan', 'raihan@gmai.com', '$2y$10$Pj/NUZr4p4d4uXZkKVsgneS7FJkDyTw09BvFHBUmnsOtBdF05aLOW', 'foto_profile/OIP.jpeg'),
(6, 'wiam', 'wiam', 'vicky.ahmad.f23@gmail.com', '$2y$10$JsYVMstnaBtJeWXoGiTAkO.cRgIZpaNUZtPlIBJ5nvTqFIlCrPyoK', 'foto_profile/unduhan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lagu`
--

CREATE TABLE `lagu` (
  `id_lagu` int(10) NOT NULL,
  `judul_lagu` varchar(255) NOT NULL,
  `lirik_lagu` longtext NOT NULL,
  `tanggal_rilis` date NOT NULL,
  `asal_daerah` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `file_sampul` varchar(255) NOT NULL,
  `file_lagu` varchar(255) NOT NULL,
  `id_album` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`);

--
-- Indexes for table `bootstrap_tb`
--
ALTER TABLE `bootstrap_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lagu`
--
ALTER TABLE `lagu`
  ADD PRIMARY KEY (`id_lagu`),
  ADD UNIQUE KEY `id_album` (`id_album`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bootstrap_tb`
--
ALTER TABLE `bootstrap_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lagu`
--
ALTER TABLE `lagu`
  MODIFY `id_lagu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
